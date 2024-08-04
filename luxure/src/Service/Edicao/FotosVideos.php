<?php

declare(strict_types=1);

namespace App\Service\Edicao;

use App\Message\EditarConta\PrimeiroEnvioMessage;
use App\Repository\Uploads\ArquivosRepository;
use App\Security\Amazon\AwsS3\Cloud;
use App\Service\Caracter\CaracteresName;
use App\Service\Converter\ConverterArquivos;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FotosVideos
{
    public function __construct(
        private Cloud $cloud,
        private ArquivosRepository $arq_envio,
        private CaracteresName $caracter,
        private ConverterArquivos $converter,
        private MessageBusInterface $bus,
        private MemcachedSessionHandler $memcached
    ) {
    }

    public function envioMongoeAws(Request $request, FormInterface $form, UserInterface $userint): true|array
    {

        if(!empty($userint->getInformacoes()->getEdicoesAtualizadas()->getPrimeiroEnvio())){
                return ['Aguarde o envio dos arquivos atuais'];
            }
        $arq = [];
        $edicao_serializado = [];

        //retirar todos os espaços vazios do array de arquivos
        $edicaoArray = $request->files->all()['finalizando_cadastro_form'];
        $edicaoArraySemVazios = array_filter($edicaoArray);
        $count = count($edicaoArraySemVazios);
        $array_heic = [];
        $array_mov = [];

        if ($count <= 2 && $count >= 13) {
            return ['Obrigatório o envio da foto de validação, capa e mais uma para o feed normal'];
        }


        if ($count >= 1 && $count <= 11) {
            $qtd_imagem = 0;

            foreach ($edicaoArraySemVazios as $key => $arquivo) {

                $nome = preg_match('/[^\/]*$/', $arquivo->getPathname(), $matches) ? $matches[0] . $arquivo->getClientOriginalExtension() : null;


                if (in_array($arquivo->getMimeType(), ["image/jpeg", "image/png", "image/heic"])) {
                    $qtd_imagem++;

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
                    'mime' => strtolower($arquivo->getMimeType())
                ];
                $arquivo->move('/home/deivid/arquivos', $nome . '.' . $extensão);
            }

            if ($qtd_imagem < 3) {
                return ["Você deve escolher no mínimo uma imagem além da sua foto de perfil e da validação"];
            }

            $env_remov['enviado'] = true;
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

        $edicao_serializado = array_merge($edicao_serializado, ['array_heic' => $array_heic, 'array_mov' => $array_mov]);
        
        $userint->getInformacoes()->getEdicoesAtualizadas()->setPrimeiroEnvio(true);
        $this->arq_envio->salveInicio($userint, [], true);

        $u_id_chave = Uuid::uuid4()->toString();
        $this->memcached->write($u_id_chave, 'true');

        
        $this->bus->dispatch(new PrimeiroEnvioMessage(
            $edicao_serializado,
            $userint,
            $detalhes,
            $u_id_chave,
            $form->getData()['username']

        ));

        return true;
    }
}
