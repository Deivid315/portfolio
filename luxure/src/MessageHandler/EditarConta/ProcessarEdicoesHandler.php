<?php

declare(strict_types=1);
//src/MessageHandler/SmsNotificationHandler.php
namespace App\MessageHandler\EditarConta;

use App\Message\EditarConta\ProcessarEdicoesMessage;
use App\Service\Converter\ConverterArquivos as ServiceConverterArquivos;
use App\MessageHandler\ExcecaoMsg;
use App\Repository\Uploads\ArquivosRepository;
use App\Security\Amazon\AwsS3\Cloud;
use App\Service\Caracter\CaracteresName;
use App\Service\Edicao\CortarArquivosTransport;
use App\Service\Edicao\ManipuladoresMensagem\EnvioExcecao;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

#[AsMessageHandler]
class ProcessarEdicoesHandler
{
    private UserInterface $userint;
    private bool $envio;
    private ?array $arq_alt;
    private int|array $removidos;
    private string $jwt;
    private ?array $edicao_serializado;
    private string $uid;


    public function __construct(
        private ServiceConverterArquivos $converter,
        private ArquivosRepository $arquivosRepository,
        private CaracteresName $caracter,
        private MessageBusInterface $bus,
        private EnvioExcecao $envioExcecao,
        private Cloud $cloud,
        private MemcachedSessionHandler $memcached,
        private LoggerInterface $logger,
        private CortarArquivosTransport $cortar
    ) {
    }

    public function __invoke(ProcessarEdicoesMessage $message)
    {
        try {
            if (!$this->memcached->validateId($message->getUId())) {
                return;
            }

            $this->userint = $message->getUserint();
            $this->removidos = $message->getRemovidos();
            $this->arq_alt = $message->getArqAlt();
            $this->jwt = $this->userint->getInformacoes()->getEdicoesAtualizadas()->getIdJwt();
            $this->edicao_serializado = $message->getEdicaoSerializado();
            $this->uid = $message->getUId();

            $array_heic = $message->getArrayHeicMov()['array_heic'];
            $array_mov = $message->getArrayHeicMov()['array_mov'];

            try {
                $this->logger->info('começou a etapa da conversão');
                //converte de jpg para heic caso haja
                if (!empty($array_heic)) {
                    foreach ($array_heic as $key) {
                        $novo = $this->converter->conversaoHeicToJpg($key['arquivo']);

                        if (isset($novo['caminho']) && isset($novo['nome'])) {
                            unset($this->edicao_serializado[$key['key']]);
                            $this->edicao_serializado[$key['key']] = $novo;
                        } else {
                            throw new ExcecaoMsg($novo['msg']);
                        }
                    }
                }

                //converter de .mov para .mp4 caso haja
                if (!empty($array_mov)) {
                    foreach ($array_mov as $key) {
                        $novo = $this->converter->conversaoParaMp4($key['arquivo']);

                        if (isset($novo['caminho']) && isset($novo['nome'])) {
                            unset($this->edicao_serializado[$key['key']]);
                            $this->edicao_serializado[$key['key']] = $novo;
                        } else {
                            throw new ExcecaoMsg($novo['msg']);
                        }
                    }
                }

                if (!empty($this->edicao_serializado)) {
                    foreach ($this->edicao_serializado as $key) {
                        if (in_array($key['mime'], ['image/jpg', 'image/png', 'image/jpeg'])) {
                            $crop = $this->cortar->cropImage($key['caminho'], $key['caminho']);
                            is_array($crop) ? throw new ExcecaoMsg($crop['msg']) : null;
                        } else if (in_array($key['mime'], ['video/mp4', 'video/webm'])) {
                            $resize = $this->cortar->resizeAndCropVideo($key['caminho']);
                            is_array($resize) ? throw new ExcecaoMsg($resize['msg']) : null;
                        } else {
                            throw new ExcecaoMsg('O tipo mime não é imagem ou vídeo então não é possível fazer o redimensionamento');
                        }
                    }
                }

                $this->logger->info('chamar função para enviar arquivos');
                $this->enviarArquivos();


                /**
                 * os alertas para o usuário serão gravados na exceção ExcecaoMsg,
                 * em seguida uso getMessage() para capturar o alerta que enviei
                 * e apresentar ao usuário. A apresentação ocorrerá de forma que 
                 * irá ser acionada a função trycatch que irá fazer 3 coisas:
                 * 1 - enviar o alerta imeditamente para o usuário através do 
                 * webhook;
                 * 2 - atualizar o banco de dados salvando o alerta;
                 * 3 - gravar no memcached o alerta para então no dashboard assim
                 * que a página for recarregada irá buscar no memcached esse alerta
                 * que estará sob o valor do phpsessid + '_atualizacao', após capturar
                 * ele será destruído.
                 * 
                 * OBS: também será salvo no memcached os arquivos originais, isto é,
                 * antes do usuário editar qualquer coisa pois ele pode ter excluído 
                 * algum arquivo, por isso quando ocorrer uma exceção será enviado 
                 * o alerta e os arquivos originais para que no dashboard possa 
                 * alterar para os arquivos originais e acrescentar o alerta atual
                 */
            } catch (ExcecaoMsg $ll) {

                $this->envioExcecao->envioTryCatch($this->userint, $this->jwt, $ll->getMessage());
                $this->memcached->destroyEspecified($this->uid);
                return;
            } catch (\Throwable $e) {
                $userint = $this->userint;
                configureScope(function (Scope $scope) use (
                    $e,
                    $userint,
                ): void {
                    $scope->setUser(
                        [
                            'nome_completo' => $this->userint->getNomeCompleto(),
                            'telefone' => $this->userint->getCelular(),
                            'email' => $this->userint->getEmail(),
                            'roles' => json_encode($this->userint->getRoles()),
                            'status' => $this->userint->getStatus()
                        ]
                    );

                    $scope->setExtra(
                        'informacoes_adicionais',
                        'Houve algum problema durante a conversão de heic para jpb ou mov para mp4'
                    );
                });
                captureException($e);

                $this->envioExcecao->envioTryCatch($this->userint, $this->jwt);
                $this->memcached->destroyEspecified($this->uid);
                return;
            }
        } catch (\Throwable $r) {
            $userint = $this->userint;
            configureScope(function (Scope $scope) use (
                $r,
            ): void {
                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve um erro desconhecido'
                );
            });
            captureException($r);
            $this->envioExcecao->envioTryCatch($this->userint, $this->jwt, 'Houve um erro durante
            o processamento dos seus dados. Caso persista entre em contado com nossa central.');
            return;
        }
    }

    private function enviarArquivos(): void
    {

        $this->logger->info('enviando arquivos');
        $salve_fotos_aws = [];
        $arquivos_atuais = $this->userint->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'];
        try {

                $edicao_serializado = [];
                foreach ($this->edicao_serializado as $key => $value) {

                    $edicao_serializado[$key] = new UploadedFile(
                        $value['caminho'],
                        $value['nome'],
                        $value['mime']
                    );
                }

                $salve_fotos_aws = $this->cloud->aws($edicao_serializado, $this->userint);
                if (!$salve_fotos_aws) {
                    throw new ExcecaoMsg('Erro ao salvar arquivos na aws s3');
                }

                if (!empty($salve_fotos_aws) && empty($this->arq_alt)) {

                    $this->arq_alt = array_merge($salve_fotos_aws, $arquivos_atuais);
                } else if (!empty($salve_fotos_aws) && !empty($this->arq_alt)) {

                    $this->arq_alt = ($this->arq_alt === $arquivos_atuais) ? $salve_fotos_aws : array_merge($this->arq_alt, $salve_fotos_aws);
                }
            

            $this->logger->info('envio concluido e chamando função apra salvar no bd');
            $this->salvarArquivos($salve_fotos_aws);
        } catch (\Throwable $e) {
            $userint = $this->userint;
            configureScope(function (Scope $scope) use (
                $e,
                $userint,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $this->userint->getNomeCompleto(),
                        'telefone' => $this->userint->getCelular(),
                        'email' => $this->userint->getEmail(),
                        'roles' => json_encode($this->userint->getRoles()),
                        'status' => $this->userint->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacao_adicional',
                    'Houve algum problema durante o envio dos arquivos para a s3'
                );
            });
            captureException($e);

            $this->envioExcecao->envioTryCatch(
                $this->userint,
                $this->jwt,
            
            );
            $this->memcached->destroyEspecified($this->uid);
            return;
        }
    }

    private function salvarArquivos(?array $fotos_salvas): void
    {

        $this->logger->info('executando salvamente no bd');
        try {
            try {

                $salve_fotos_mongodb = $this->arquivosRepository->uploadsFotosEVideos(
                    $this->arq_alt,
                    $this->userint->getConteudosDaConta()->getArquivosPrivados()['detalhes'],
                    $this->userint,
                    true
                );

                if (is_array($salve_fotos_mongodb)) {
                    throw new ExcecaoMsg('Erro ao salvar perfil editado do usuário no mongodb');
                }
            } catch (\Throwable $e) {
                $userint = $this->userint;
                configureScope(function (Scope $scope) use (
                    $e,
                    $userint,
                ): void {
                    $scope->setUser(
                        [
                            'nome_completo' => $this->userint->getNomeCompleto(),
                            'telefone' => $this->userint->getCelular(),
                            'email' => $this->userint->getEmail(),
                            'roles' => json_encode($this->userint->getRoles()),
                            'status' => $this->userint->getStatus()
                        ]
                    );

                    $scope->setExtra(
                        'informacoes_adicionais',
                        'Houve algum problema durante o salvamento dos arquivos do usuário no mongodb então caso
                    ele tenha feito o upload de algum arquivo será excluído.'
                    );
                });
                captureException($e);

                $this->envioExcecao->envioTryCatch(
                    $this->userint,
                    $this->jwt,
                
                );

                $this->memcached->destroyEspecified($this->uid);

                if (!empty($fotos_salvas)) {
                    $this->cloud->deleteAws($fotos_salvas, $this->userint);
                }

                return;
            }

            if ($this->memcached->validateId($salve_fotos_mongodb->getId())) {

                $envie = [
                    'arquivos_publicos' => $salve_fotos_mongodb->getConteudosDaConta()->getArquivosPublicos(),
                ];

                $this->logger->info('ta online');

                $rr = $this->memcached->write($salve_fotos_mongodb->getId() . '_atualizacao', serialize($envie));
                $this->logger->info('o resultado é: ', [$rr]);

                if (!empty($fotos_salvas)) {
                    $this->enviarWebhook($fotos_salvas);
                }
            } else {
                $this->logger->info('não ta online');
            }

            $this->memcached->destroyEspecified($this->uid);

            $this->logger->info('finalizando salvamento e chamando função de deleção caso haja');
            if (is_array($this->removidos)) {
                $this->removerArquivos();
            }
        } catch (\Throwable $e) {
            $userint = $this->userint;
            configureScope(function (Scope $scope) use (
                $e,
                $userint,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $this->userint->getNomeCompleto(),
                        'telefone' => $this->userint->getCelular(),
                        'email' => $this->userint->getEmail(),
                        'roles' => json_encode($this->userint->getRoles()),
                        'status' => $this->userint->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante o processo de salvamento dos arquivos do usuário no mongodb
                     que não envolve necessariamente o mongodb.'
                );
            });
            captureException($e);

            $this->envioExcecao->envioTryCatch(
                $this->userint,
                $this->jwt,
            
            );

            $this->memcached->destroyEspecified($this->uid);
            return;
        }
    }

    private function removerArquivos(): void
    {

        try {
            $this->logger->info('função de deleção excecutando');

            $delete_fotos_e_videos = $this->cloud->deleteAws($this->removidos, $this->userint);

            if (!$delete_fotos_e_videos) {
                throw new ExcecaoMsg('Erro ao deletar arquivos na aws s3');
            }
            $this->logger->info('função de deleão finalizida');
        } catch (\Throwable $e) {
            $userint = $this->userint;
            configureScope(function (Scope $scope) use (
                $e,
                $userint,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $this->userint->getNomeCompleto(),
                        'telefone' => $this->userint->getCelular(),
                        'email' => $this->userint->getEmail(),
                        'roles' => json_encode($this->userint->getRoles()),
                        'status' => $this->userint->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Não foi possível excluir os arquivos do s3, terá que ser feita exclusão manual a não ser que o cron esteja ativado'
                );
            });
            captureException($e);

            return;
        }
    }

    private function enviarWebhook(array $fotos): void
    {

        $userData = [
            //'sexualidade' => $fotos->getSexualidade(),
            'arquivos_publicos' => [
                $fotos
            ]
        ];

        $client = new Client();
        $client->post('http://localhost:3000/emit', [
            'json' => [
                'texts' => $userData,
                'jwt' => $this->jwt
            ]
        ]);
    }
}
