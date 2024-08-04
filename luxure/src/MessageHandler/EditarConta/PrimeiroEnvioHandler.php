<?php

namespace App\MessageHandler\EditarConta;

use App\Message\EditarConta\PrimeiroEnvioMessage;
use App\MessageHandler\ExcecaoMsg;
use App\Repository\Uploads\ArquivosRepository;
use App\Security\Amazon\AwsS3\Cloud;
use App\Service\Converter\ConverterArquivos;
use App\Service\Edicao\CortarArquivosTransport;
use App\Service\Edicao\ManipuladoresMensagem\EnvioExcecao;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

use function Sentry\captureException;
use function Sentry\configureScope;

#[AsMessageHandler]
class PrimeiroEnvioHandler
{

    public function __construct(
        private Cloud $cloud,
        private ArquivosRepository $arquivosRepository,
        private MemcachedSessionHandler $memcached,
        private LoggerInterface $logger,
        private ConverterArquivos $converter,
        private CortarArquivosTransport $cortar,
        private EnvioExcecao $envioExcecao
    ) {
    }

    public function __invoke(PrimeiroEnvioMessage $message)
    {
        if (!$this->memcached->validateId($message->getUid())) {
            return;
        }
        $edicaoSerializado = $message->getEdicaoSerializado();
        //converter arquivos aqui

        $array_heic = $edicaoSerializado['array_heic'];
        $array_mov = $edicaoSerializado['array_mov'];
        unset($edicaoSerializado['array_heic'], $edicaoSerializado['array_mov']);
        $user = $message->getUser();
        $jwt = $user->getInformacoes()->getEdicoesAtualizadas()->getIdJwt();

        $this->logger->info('começou a etapa da conversão');

        try {
            //converte de jpg para heic caso haja
            if (!empty($array_heic)) {
                foreach ($array_heic as $key) {
                    $novo = $this->converter->conversaoHeicToJpg($key['arquivo']);

                    if (isset($novo['caminho']) && isset($novo['nome'])) {
                        unset($edicaoSerializado[$key['key']]);
                        $edicaoSerializado[$key['key']] = $novo;
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
                        unset($edicaoSerializado[$key['key']]);
                        $edicaoSerializado[$key['key']] = $novo;
                    } else {
                        throw new ExcecaoMsg($novo['msg']);
                    }
                }
            }

            if (!empty($edicaoSerializado)) {
                foreach ($edicaoSerializado as $key) {
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
        } catch (ExcecaoMsg $ll) {

            $this->envioExcecao->envioTryCatch($user, $jwt, $ll->getMessage(), true);
            $this->memcached->destroyEspecified($message->getUid());
            return;
        } catch (\Throwable $e) {
            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a conversão de heic para jpg ou mov para mp4'
                );
            });
            captureException($e);

            $this->envioExcecao->envioTryCatch($user, $jwt, 'Houve um erro em nossos serviços, tente enviar seus arquivos mais tarde', true);
            $this->memcached->destroyEspecified($message->getUid());
            return;
        }

        $this->logger->info('enviar arquivos');

        $edicao_serializado = [];
        foreach ($edicaoSerializado as $key => $value) {

            $edicao_serializado[$key] = new UploadedFile(
                $value['caminho'],
                $value['nome'],
                $value['mime']
            );
        }

        try {
            $caa = $edicao_serializado['capa']->getClientOriginalExtension();
            $this->logger->info('capa ======= ',[ $caa]);
            $xt = $edicao_serializado['validacao']->getClientOriginalExtension();
            $this->logger->info('validacao ======= ',[ $xt]);
            $salve_fotos_aws = $this->cloud->aws($edicao_serializado, $user);

            if (!$salve_fotos_aws) {
                throw new ExcecaoMsg('Erro ao salvar arquivos na aws s3');
            }
            $this->logger->info('envio concluido e chamando função apra salvar no bd');
        } catch (\Throwable $c) {
            configureScope(function (Scope $scope) use (
                $c,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacao_adicional',
                    'Houve algum problema durante o envio dos primeiros arquivos para a s3'
                );
            });
            captureException($c);

            $this->envioExcecao->envioTryCatch($user, $jwt, 'Houve um erro em nossos serviços, tente enviar seus arquivos mais tarde', true);
            $this->memcached->destroyEspecified($message->getUid());

            return;
        }

        /**
         * depois de salva as fotos na aws s3 que retornara um array contendo os
         * links para acessar as imagens, os mesmos serão salvos no documento
         * do usuário no mongodb. As fotos publicas serão salvas em publico
         * enquanto a foto de validação ficará salva em privado.
         * 
         * Se não for possível salvar as fotos no mongodb então será acionada
         * uma exceção deletando os arquivos que outrora foram enviados para
         * o s3 revertendo a sessão do usuário para quando os arquivos estavam vazios,
         * pois antes de salvar os arquivos no mongodb eles são salvos na sessão
         * do usuário logado, assim não é necessári fazer uma busca no bd para
         * então retornar o user atualizado, dessa forma o programa fica mais leve,
         * portanto caso haja algum erro durante o envio o estado de 'arquivos' é
         * revertido ao estado anterior (antes de fazer o upload das fotos e vídeos
         * no s3 ) e então são deletados da s3
         * 
         * caso tudo ocorra bem então após inserir os arquivos no objeto user é 
         * atualizado o roles de ROLE_USER_N1 para ROLE_USER_N2, dessa forma
         * ele não vai poder acessar mais a página para inserir as informações
         * iniciais bem como inserir a foto de validação, em seguida é atualizado
         * o tokenstorage para que as mudanças se reflitam de imeditado na sessão
         * sem que seja necessário deslogar o usuário
         * 
         * OBS: antes de salvar os arquivos de fato no mongodb é feita uma separação
         * onde a foto de validação será salva em um local privado tanto no mongodb
         * quanto na s3 e os outros arquivos serão salvos em uma pasta pública
         */
        try {
            $salve_fotos_mongodb = $this->arquivosRepository->uploadInicial(
                $salve_fotos_aws,
                $message->getDetalhes(),
                $user,
                $message->getUsername()
            );

            if (is_array($salve_fotos_mongodb)) {
                throw new ExcecaoMsg('Erro ao salvar perfil editado do usuário no mongodb');
            }
        } catch (\Throwable $e) {
            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante o salvamento dos arquivos do usuário no mongodb então os arquivos
                     serão excluidos, detalhe que esse é o primeiro envio do usuário.'
                );
            });
            captureException($e);

            $this->cloud->deleteAws($salve_fotos_aws, $user);

            $this->envioExcecao->envioTryCatch($user, $jwt, 'Houve um erro em nossos serviços, tente enviar seus arquivos mais tarde', true);

            $this->memcached->destroyEspecified($message->getUid());

            return;
        }

        $this->logger->info('executando salvamente no bd');

        $this->logger->info('arquivos com a foto: ', $salve_fotos_aws);
        unset($salve_fotos_aws[0]);
        $salve_fotos_aws = array_values($salve_fotos_aws);
        $this->logger->info('arquivos sem a foto: ', $salve_fotos_aws);

        $envie = [
            'arquivos_publicos' => $salve_fotos_aws,
        ];


        if ($this->memcached->validateId($salve_fotos_mongodb->getId())) {

            $envie = [
                'primeiro_envio' => [
                    'dados' => $salve_fotos_mongodb->getConteudosDaConta()
                    ]
            ];

            $this->logger->info('ta online');

            $rr = $this->memcached->write($salve_fotos_mongodb->getId() . '_atualizacao', serialize($envie));
            $this->logger->info('o resultado é: ', [$rr]);
            $this->envioExcecao->setWebhook($jwt, "Sua conta já pode ser utilizada");
        } else {
            $this->logger->info('não ta online');
        }

        $this->memcached->destroyEspecified($message->getUid());
    }

}
