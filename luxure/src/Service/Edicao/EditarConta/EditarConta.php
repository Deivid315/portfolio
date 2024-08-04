<?php

declare(strict_types=1);

namespace App\Service\Edicao\EditarConta;

use App\Message\EditarConta\ProcessarEdicoesMessage;
use App\Repository\Uploads\ArquivosRepository;
use App\Security\Amazon\AwsS3\Cloud;
use App\Service\Converter\ConverterArquivos as ConverterConverterArquivos;
use AsyncAws\Core\Exception\Http\NetworkException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Sentry\State\Scope;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class EditarConta
{

    public function __construct(
        private MessageBusInterface $bus,
        private ConverterConverterArquivos $converter,
        private DocumentManager $dm,
        private ArquivosRepository $arquivosRepository,
        private MemcachedSessionHandler $memcached,
        private LoggerInterface $logger,
        private TokenStorageInterface $tokenStorageInterface,
        private RequestStack $requestStack,
        private Cloud $cloud
    ) {
    }


    public function areUsersIdentical(UserInterface $user1, UserInterface $user2): bool
    {
        return $this->areObjectsIdentical($user1, $user2);
    }

    private function areObjectsIdentical($object1, $object2): bool
    {
        if (get_class($object1) !== get_class($object2)) {
            return false;
        }

        $reflection1 = new \ReflectionClass($object1);
        $reflection2 = new \ReflectionClass($object2);

        $properties1 = $reflection1->getProperties();
        $properties2 = $reflection2->getProperties();

        if (count($properties1) !== count($properties2)) {
            return false;
        }

        foreach ($properties1 as $property) {
            $propertyName = $property->getName();

            // Verifica se a propriedade está inicializada no primeiro objeto
            if ($reflection1->hasProperty($propertyName)) {
                $property1 = $reflection1->getProperty($propertyName);
                $property1->setAccessible(true);

                if (!$property1->isInitialized($object1)) {
                    continue;
                }
            }

            // Verifica se a propriedade está inicializada no segundo objeto
            if ($reflection2->hasProperty($propertyName)) {
                $property2 = $reflection2->getProperty($propertyName);
                $property2->setAccessible(true);

                if (!$property2->isInitialized($object2)) {
                    continue;
                }
            }

            // Obtém os valores das propriedades
            $value1 = $property1->getValue($object1);
            $value2 = $property2->getValue($object2);

            // Compara os valores das propriedades
            if (is_object($value1) && is_object($value2)) {
                if (!$this->areObjectsIdentical($value1, $value2)) {
                    return false;
                }
            } elseif ($value1 !== $value2) {
                return false;
            }
        }

        return true;
    }

    public function processEdicaoConta(
        Request $request,
        FormInterface $form,
        UserInterface $userint,
        ?array $cookie_sessao
    ): array {


        if ($userint->getInformacoes()->getEdicoesAtualizadas()->getStatus()) {
            return ['aguarde o envio dos arquivos atuais'];
        }

        $edicaoArray = $request->files->all()['edit_perfil_form'];
        $edicaoArraySemVazios = array_filter($edicaoArray);
        $count = count($edicaoArraySemVazios);
        $arq_alt = null;
        $array_heic = [];
        $array_mov = [];
        $detalhes = null;
        $remov_sep = 0;
        $arq_removidos = 0;
        $envio = false;
        $hasImage = 0;
        $foto_de_perfil = false;
        $fotoevideo = $userint->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'];
        $edicao_serializado = [];
        $chave_id = base64_encode(sodium_crypto_generichash($request->getSession()->getId(), '', 40));
        $env_remov = ['enviado' => false, 'removido' => false, 'id' => $chave_id, 'tempo' => null];
        $removidos = $form->getData()['arqs_removidos'] ?? null;

        /**
         * todas as imagens que são removidas ficam no input arq_removidas
         * caso a ele esteja vazio então lhe é atribuído null, o que
         * quer dizer que o usuário não removeu nenhuma imagem
         * 
         * se ele tiver removido a foto de perfil é verificado se ele
         * enviou também ela pois é obrigatório
         */
        if (!empty($removidos)) {

            $remov_sep = preg_split('/,/', $removidos, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($remov_sep as $key => $value) {
                if (strpos($value, 'foto_de_perfil_da_conta') !== false) {
                    if (empty($request->files->get('edit_perfil_form')['capa'])) {
                        return ['msg' => 'é obrigatório o envio de uma foto de perfil'];
                    }
                    $foto_de_perfil = true;
                }
            }

            if (count($fotoevideo) === (count($remov_sep) + 1) && !$count) {
                return ['msg' => 'é obrigatório o envio de 1 imagem além da capa de perfil.'];
            }

            $arq_alt = array_diff($fotoevideo, $remov_sep);
            $arq_alt = empty($arq_alt) ? $fotoevideo : $arq_alt;

            $env_remov['removido'] = true;
        }

        if ($count >= 1 && $count <= 11) {

            $conta_fotos = count($userint->getConteudosDaConta()->getArquivosPublicos()['fotosevideos']);

            $rr = is_array($remov_sep) ? count($remov_sep) : 0;
            if (($conta_fotos + $count - $rr) > 11) {
                return ['msg' => 'Houve um erro em relação a quantidade de arquivos enviados, por favor faça login novamente, caso o problema
                 persista então contate nossa equipe.'];
            }

            foreach ($edicaoArraySemVazios as $key => $arquivo) {

                $nome = preg_match('/[^\/]*$/', $arquivo->getPathname(), $matches) ? $matches[0] . $arquivo->getClientOriginalExtension() : null;


                if (in_array($arquivo->getMimeType(), ["image/jpeg", "image/png", "image/heic"])) {

                    /**
                     * função para apenas confirmar se uma imagem é heic,
                     * se for então será enviado o tipo mime 'image/jpg'
                     * para a variável $arq e vai ser salvo o name do campo 
                     * dela enviado pelo formulário junto do objeto 
                     * uploadfile na variável $array_heic.
                     * É necessário salvar a o name atual (se é o arq_9,
                     * arq_1, etc (o name do campo input dos arquivos
                     *  no formulario variam de arq_0 atáé arq_10)) juntamente
                     * do objeto uploadfile para em seguida fazer a conversão
                     * dele para jpg. Após a conversão será excluído do array
                     * $edicaoArraySemVazios (variável contendo os arquivos
                     * que serão salvos na s3) a chave que possui aquele name
                     * e em seu lugar adicionado o novo convertido.
                     * ex: foi enviado um arquivo no input cujo name é arq_7,
                     * foi verificado que é uma imagem .heic, nesse caso será
                     * salvo arq_7 e o arquivo enviado no $array_heic e será
                     * adicionado a $arq (variável que será usada para validações
                     * futuras) a string 'image/jpg' já pressupondo que ocorrerá
                     * tudo bem durante a conversão da imagem. Após verificar
                     * todas as imagens então é verificado se $array_heic está
                     * vazio, o que significaria que não existe nenhuma imagem
                     * nesse formato, caso não esteja é feito a conversão e então
                     * éinstanciado e criado um novo uploadfile tendo o tipo mime
                     * image/jpg e o caminho sendo o da nova imagem convertida para
                     * jpg, com conversão bem sucedida é excluído do $edicaoArraySemVazios o uploadfile da
                     * chave arq_7 (antiga imagem heic) e é salvo a nova chave sendo
                     * também arq_7 porém agora seu valor será o uploadfile (atual 
                     * imagem jpg).
                     * 
                     * 
                     *  obs: é necessário salvar o tipo mime de todos os
                     * arquivos no array $arq porque é com base nisso que
                     * será verificado se o usuário enviou alguma coisa ou
                     * se enviou apenas vídeos e deixou somente vídeos na 
                     * conta ou se enviou apenas a foto de perfil e excluiu
                     * o resto todo
                     * 
                     */
                    $converter_heic = $this->converter->confirmHeic($arquivo->getPathname());
                    if ($converter_heic) {
                        $array_heic[] = [
                            'key' => $key,
                            'arquivo' => [
                                'nome' => $nome . '.heic',
                                'caminho' => '/home/deivid/arquivos/' . $nome . '.heic',
                                'mime' => $arquivo->getMimeType()
                            ]
                        ];
                        $arq[] = 'image/jpg';
                    } else {
                        $arq[] = $arquivo->getMimeType();
                    }
                } else if (in_array($arquivo->getMimeType(), ["video/mp4", "video/webm", "video/quicktime"])) {

                    $converter_mov = $this->converter->confirmMov($arquivo->getMimeType());
                    if ($converter_mov) {
                        $array_mov[] = [
                            'key' => $key,
                            'arquivo' => [
                                'nome' => $nome . '.mov',
                                'caminho' => '/home/deivid/arquivos/' . $nome . '.mov',
                                'mime' => $arquivo->getMimeType()
                            ]
                        ];
                        $arq[] = 'video/mp4';
                    } else {
                        $arq[] = $arquivo->getMimeType();
                    }
                } else {
                    return ['msg' => 'O arquivo ' . $arquivo->getClientOriginalName() . ' não está no formato MIME correto'];
                }

                $extensão = null;
                switch (true) {
                    case $arquivo->getMimeType() === 'video/mp4':
                        $extensão = 'mp4';
                        break;
                    case $arquivo->getMimeType() === 'video/webm':
                        $extensão = 'webm';
                        break;
                    case $arquivo->getMimeType() === 'video/quicktime':
                        $extensão = 'mov';
                        break;
                    case $arquivo->getMimeType() === 'image/jpeg':
                        $extensão = 'jpeg';
                        break;
                    case $arquivo->getMimeType() === 'image/png':
                        $extensão = 'png';
                        break;
                    case $arquivo->getMimeType() === 'image/heic':
                        $extensão = 'heic';
                        break;
                    default:
                        return ['msg' => 'arquivos inconsistentes'];
                }
                $edicao_serializado[$key] = [
                    'nome' => $nome . '.' . $extensão,
                    'caminho' => '/home/deivid/arquivos/' . $nome . '.' . $extensão,
                    'mime' => $arquivo->getMimeType()
                ];
                $arquivo->move('/home/deivid/arquivos', $nome . '.' . $extensão);
            }

            foreach ($arq as $tipo) {
                if (strpos($tipo, 'image/') === 0) {
                    $hasImage++;
                }
            }

            if ($remov_sep && count($fotoevideo) === (count($remov_sep) + 1) && $hasImage === 0) {
                return ['msg' => 'é obrigatório o envio de 1 imagem além da capa de perfil.'];
            }

            $envio = true;
            $env_remov['enviado'] = true;
        }

        /**
         * é feita uma verificação caso o usuário tenha removido
         * algum arquivo:
         * 
         * conte quantas imagens e vídeos o usuário deletou
         * conte quantas ele não deletou 
         * conte quantas ele fez o upload
         * verifique se ele removeu ou não a foto de perfil
         * 
         * é feita uma conta onde se ele tiver deletado
         * todas as imagens menos a capa e se no perfil tiver 1 vídeo
         * ou mais e se ele não tiver feito nenhum upload de imagem
         * então é mostrado que ele é obrigado a enviar ao menos
         * 1 imagem
         * 
         * em seguida é verificado pelo outro if:
         * 
         * se ele tiver detaldo todas as imagens incluindo a
         * foto de perfil e se no perfil ainda tiver 1 vídeo
         * ou mais e se ele não tiver feito o upload de nenhuma
         * imagem então novamente é mostrado alerta de erro
         * 
         * ou seja, o usuário só pode prosseguir se em sua conta
         * tiver uma imagem ou mais além da foto de perfil
         */
        if (!empty($arq_alt)) {
            $imagens = 0;
            $videos = 0;
            $imagens2 = 0;
            $videos2 = 0;

            foreach ($arq_alt as $key => $value) {
                if (strpos($value, ".png") !== false || strpos($value, ".jpg") !== false || strpos($value, ".jpeg") !== false) {
                    $imagens++;
                } elseif (strpos($value, ".mp4") !== false || strpos($value, ".webm") !== false) {
                    $videos++;
                }
            }

            foreach ($remov_sep as $key => $value) {
                if (strpos($value, ".png") !== false || strpos($value, ".jpg") !== false || strpos($value, ".jpeg") !== false) {
                    $imagens2++;
                } elseif (strpos($value, ".mp4") !== false || strpos($value, ".webm") !== false) {
                    $videos2++;
                }
            }

            if ($imagens === 1 && $videos >= 1 && !$hasImage && !$foto_de_perfil) {
                return ['msg' => 'É obrigatório o envio de uma imagem, pois a conta não pode ter apenas vídeos.'];
            } elseif ($imagens === 0 && $videos >= 1 && $hasImage <= 1 && $foto_de_perfil) {
                return ['msg' => 'É obrigatório o envio de uma imagem, pois a conta não pode ter apenas vídeos.'];
            }
        }


        $detalhes = [
            'biografia' => $form->getData()['biografia'],
            'valor' => $form->getData()['valor'],
            'altura' => $form->getData()['altura'],
            'peso' => $form->getData()['peso'],
            'local' => $form->getData()['local'],
            'etnia' => $form->getData()['etnia'],
            'sexualidade' => $form->getData()['sexualidade'],
            'cabelo' => $form->getData()['cabelo'],
            'posicao' => $form->getData()['posicao'],
            'fetiches' => $form->getData()['fetiches']
        ];

        $cont = 0;
        /**
         * é varificado se os valores do array de detalhes atual
         * são os mesmo valores do array de detalhes que foi enviado
         * pelo formulário, caso haja alguma divergência então é
         * somado +1 em $cont (que é responsável unicamente para
         * fins de controle ao saber se o usuário alterou alguma
         * coisa ou não)
         */
        foreach ($userint->getConteudosDaConta()->getArquivosPublicos()['detalhes'] as $det => $value) {
            if ($detalhes[$det] !== $value) {
                $cont++;
            }
        }

        if (empty($removidos) && !$cont && !$envio) {
            return ['msg' => 'nenhum arquivo alterado'];
        }

        if ($foto_de_perfil && $envio) {
            $count--;
            $arq_env = $count;
        } else if (!$foto_de_perfil && $envio) {
            $arq_env = $count;
        }

        try {

            // $user = $this->dm->getRepository(User::class)->findOneBy(['email' => $userint->getEmail()]);

            if (!$env_remov['enviado']) {

                $userint->getConteudosDaConta()->setArquivosPublicos(
                    [
                        'fotosevideos' => $remov_sep ? array_values($arq_alt) : $fotoevideo,
                        'detalhes' => $cont ? $detalhes : $userint->getConteudosDaConta()->getArquivosPublicos()['detalhes'],
                    ]
                );
                $this->arquivosRepository->salveInicio($userint, ['cont' => (bool) $cont, 'remov_sep' => $env_remov['removido']]);
                $remov_sep ? $this->cloud->deleteAws($remov_sep, $userint) : null;
                return ['msg' => 'enviadooooooooooooo'];
            }
            //var_dump($userint->getInformacoes()->getEdicoesAtualizadas());
            if (isset($arq_env)) {
                $userint->getInformacoes()->getEdicoesAtualizadas()->setQtd($arq_env);
                $userint->getInformacoes()->getEdicoesAtualizadas()->setCapa($foto_de_perfil);
                $userint->getInformacoes()->getEdicoesAtualizadas()->setStatus(true);
            }

            //var_dump($userint->getInformacoes()->getEdicoesAtualizadas());
            //exit;
            if ($arq_alt === $userint->getConteudosDaConta()->getArquivosPublicos()['fotosevideos']) {

                $userint->getConteudosDaConta()->setArquivosPrivados(
                    [
                        'fotosevideos' => [],
                        'detalhes' => $detalhes,
                    ]
                );
            } else {
                $userint->getConteudosDaConta()->setArquivosPrivados(
                    [
                        'fotosevideos' => !empty($removidos) ? array_values($arq_alt) : $userint->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'],
                        'detalhes' => $detalhes,
                    ]
                );
            }

            $salv = $this->arquivosRepository->salveInicio($userint);

            $u_id_chave = Uuid::uuid4()->toString();
            $resp = $this->memcached->write($u_id_chave, 'true');
            $this->logger->info('criado com chave ' . $u_id_chave . ' e resultado do salvamente foi: ' . $resp);

            if ($salv) {

                $this->bus->dispatch(new ProcessarEdicoesMessage(
                    ['array_heic' => $array_heic, 'array_mov' => $array_mov],
                    $userint,
                    $edicao_serializado,
                    $arq_alt,
                    $remov_sep,
                    $u_id_chave,
                ));
                return ['msg' => 'enviado mensagem'];
            } else {
                $userint->getConteudosDaConta()->setArquivosPrivados([]);
                $userint->getInformacoes()->getEdicoesAtualizadas()->setQtd(0);
                $userint->getInformacoes()->getEdicoesAtualizadas()->setCapa(false);
                $userint->getInformacoes()->getEdicoesAtualizadas()->setStatus(false);
                return ['msg' => 'Houve um erro em nossos serviços, tente novamente mais tarde'];
            }
        } catch (\Throwable $l) {
            configureScope(function (Scope $scope) use ($l, $userint) {

                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );

                $scope->setExtra('informacoes_adicionais', 'Houve um erro durante o envio da primeira mensagem para o transport');
            });
            captureException($l);
            return ['msg' => 'Houve um erro em nossos serviços'];
        }
    }
}
