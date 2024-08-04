<?php

declare(strict_types=1);

namespace App\Service\Converter;

use Exception;
use Maestroerror\HeicToJpg;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use CloudConvert\Models\ImportFile;
use CloudConvert\Models\ExportUrl;

class ConverterArquivos
{

    public function confirmHeic(string $caminho): bool
    {
        $heictojpg = new HeicToJpg;
        return $heictojpg->isHeic($caminho);
    }

    /**
     * como alguns navegadores não suportam o formato heic então
     * estou usando uma biblioteca que converte heic para jpg
     * 
     * o objeto com formato heic vai ser deletado do array
     * edicaoArraySemVazios e em seu lugar vai entrar 
     * quase que o mesmo objeto porém com o novo nome tendo
     * .jpg no final e o arquivo em tmp sendo o novo arquivo
     * convertido
     */
    public function conversaoHeicToJpg(array $arquivo): array
    {

        $heictojpg = new HeicToJpg;
        // Cria um arquivo temporário no diretório especificado
        $caminhoTemporario = tempnam('/home/deivid/arquivos/', 'heic_to_jpg_');

        // Converte a imagem HEIC para JPG e salva no caminho temporário
        $salvo = $heictojpg->convertImage($arquivo['caminho'])
            ->saveAs($caminhoTemporario);

        if (!$salvo) {
            // Retorna uma mensagem de erro se a conversão falhar
            return [
                'msg' => 'Você enviou uma imagem com formato .heic que não pôde ser processada, por favor envie outro tipo de imagem.'
            ];
        }

        // Renomeia o arquivo convertido para o nome desejado
        $novoNomeArquivo = $arquivo['nome'] . 'convert';
        $caminhoFinal = '/home/deivid/arquivos/' . $novoNomeArquivo . '.jpg';

        // Move o arquivo temporário para o caminho final com o novo nome
        if (!rename($caminhoTemporario, $caminhoFinal)) {
            return ['msg' => 'Erro ao renomear o arquivo convertido.'];
        }

        // Retorna as informações do novo arquivo convertido
        $novo = [
            'caminho' => $caminhoFinal,
            'nome' => $novoNomeArquivo . '.jpg',
            'mime' => 'image/jpg'
        ];

        return $novo;
    }

    public function confirmMov(string $caminho): bool
    {
        return $caminho === 'video/quicktime' ? true : false;
    }

    public function conversaoParaMp4(array $arquivo): array
    {

        $chave = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjg5YmFlM2YwOTdhYThiNDFkOWMwZmE1N2UyMGM3MTgyOWY3MjYxNjM1YmQzMmExNjI4YzM0MjMwMzdkMGYyN2MyYTU5NjY0MzI5Yjg0NWYiLCJpYXQiOjE3MTY3MzExNzMuOTAxMzQ0LCJuYmYiOjE3MTY3MzExNzMuOTAxMzQ2LCJleHAiOjQ4NzI0MDQ3NzMuODk2NDkxLCJzdWIiOiI2ODQ5NDI2NiIsInNjb3BlcyI6WyJ1c2VyLnJlYWQiLCJ1c2VyLndyaXRlIiwidGFzay53cml0ZSIsInRhc2sucmVhZCIsIndlYmhvb2sucmVhZCIsIndlYmhvb2sud3JpdGUiLCJwcmVzZXQucmVhZCIsInByZXNldC53cml0ZSJdfQ.eKAZkcRQClvHKqLmdkvjxVTjNvpJGQgGnOQwdi8Vd7uSkpf1uO39sH7_zvsyPa5vS4fAWfM4GCkEnAbDrPRg3YhG1SWQAxgEvYTNKIo7rNrJ7ZL7kxMeCNWrRdfQPa9j7-QpCXEA6hf1ekIsrmuAbYyKtEpW6C8c7EOugBzGrTdkCvI7WU4Do2wBjjawPEVNpHP-8SYJ8EX3pRPG5kr6hE7W2OM8n711hjbum2TryO9I609p7OM8Mk80gi33deDmZcG3Trqenlwcl4sJWiXSs3xKrk_TRYwQzUeRIgwmPVBSrDS6dUVWvJeHAj4xa87E5Va32dEp15f9ZshBIJc39D6LtAzaGrhDOlLRqhwkkwrWTb3KT1PbqFAAhbW4yLGekKK5GdcpaPWyDJCGbby7R_IxlOlQopcnDCy6ITb56Rw8oNyzPtORsWSBWqvOWce_YAE-t4mdUT4n9_k2G7TwJjWVzkW0PNvjaE9CcLKIHKype8v_3uMszpnsTc7tc2ZV_H4gPmFQTR65Q5ycLikfJi0yEFHC9t3iTesqgCR0BiI8K-7h5K53w7Vggvzp2cFYk1JiksFLzySztwcoQnEUxtmuo05ItOw92JYyH1-Cav0Z0VueWS5qKMmtpzWWx1sQLnlX8PKYCn3wvBlqDLvgSKz9q0gZ5YC_d0A1hlEpSRc';


        $inputfile = $arquivo['caminho'];
        $nome = pathinfo($inputfile, PATHINFO_FILENAME);

        $cloudconvert = new CloudConvert([
            'api_key' => $chave,
            'sandbox' => false
        ]);

        // Criar o trabalho de conversão
        $job = (new Job())
            //->setTag('php-cloudconvert-example')
            ->addTask(
                (new Task('import/upload', 'import-1'))
            )
            ->addTask(
                (new Task('convert', 'task-1'))
                    ->set('input_format', 'mov')
                    ->set('output_format', 'mp4')
                    ->set('engine', 'ffmpeg')
                    ->set('input', 'import-1')
                    ->set('video_codec', 'x264')
                    ->set('crf', 20)
                    ->set('preset', 'medium')
                    ->set('fit', 'scale')
                    ->set('subtitles_mode', 'none')
                    ->set('audio_codec', 'aac')
                    ->set('audio_bitrate', 128)
            )
            ->addTask(
                (new Task('export/url', 'export-1'))
                    ->set('input', 'task-1')
                //->set('inline', true)
            );

        $job = $cloudconvert->jobs()->create($job);

        $uploadTask = $job->getTasks()->whereName('import-1')[0];
        $cloudconvert->tasks()->upload($uploadTask, fopen($inputfile, 'r'), $nome . '.mov');

        $cloudconvert->jobs()->wait($job);

        foreach ($job->getExportUrls() as $file) {
            $source = $cloudconvert->getHttpTransport()->download($file->url)->detach();
            $fileBaseName = pathinfo($file->filename, PATHINFO_FILENAME);
            $dest = fopen('/home/deivid/arquivos/' . $fileBaseName . '.mp4', 'w');

            stream_copy_to_stream($source, $dest);
            fclose($dest);
        }

        $novo_upload = [
            'caminho' => '/home/deivid/arquivos/' . $fileBaseName . '.mp4',
            'nome' => $arquivo['nome'] . '.mp4',
            'mime' => 'video/mp4'
        ];

        return $novo_upload;
    }
}
