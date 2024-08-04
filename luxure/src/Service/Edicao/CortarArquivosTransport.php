<?php

declare(strict_types=1);

namespace App\Service\Edicao;

class CortarArquivosTransport
{

    public function cropImage(string $sourcePath, string $destinationPath, int $targetWidth = 1080, int $targetHeight = 1920): array|true
    {
        list($origWidth, $origHeight, $type) = getimagesize($sourcePath);
        $mime = image_type_to_mime_type($type);

        switch ($mime) {
            case 'image/jpeg':
                $imageCreateFunc = 'imagecreatefromjpeg';
                $imageSaveFunc = 'imagejpeg';
                break;

            case 'image/png':
                $imageCreateFunc = 'imagecreatefrompng';
                $imageSaveFunc = 'imagepng';
                break;

            default:
                return ['msg' => 'Erro ao cortar imagens pois não é do tipo mime/png ou jpeg'];
        }

        $image = $imageCreateFunc($sourcePath);

        // Calcular a proporção de redimensionamento
        $scale = max($targetWidth / $origWidth, $targetHeight / $origHeight);
        $newWidth = intval($origWidth * $scale);
        $newHeight = intval($origHeight * $scale);

        // Criar imagem redimensionada
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Cortar a imagem redimensionada para o tamanho desejado
        $croppedImage = imagecreatetruecolor($targetWidth, $targetHeight);
        $src_x = intval(($newWidth - $targetWidth) / 2);
        $src_y = intval(($newHeight - $targetHeight) / 2);
        imagecopyresampled($croppedImage, $resizedImage, 0, 0, $src_x, $src_y, $targetWidth, $targetHeight, $targetWidth, $targetHeight);

        // Salvar a imagem cortada
        $imageSaveFunc($croppedImage, $destinationPath);

        // Limpar memória
        imagedestroy($image);
        imagedestroy($resizedImage);
        imagedestroy($croppedImage);

        return true;
    }


    public function resizeAndCropVideo(string $sourcePath, int $targetWidth = 1080, int $targetHeight = 1920): array|true
    {
        // Verifique se o arquivo de origem existe
        if (!file_exists($sourcePath)) {
            return ['msg' => 'Arquivo de origem não encontrado'];
        }

        // Definir o caminho do arquivo temporário
        $tempPath = sys_get_temp_dir() . '/temp_video.mp4';

        // Primeiro, redimensione o vídeo para que a menor dimensão seja igual à dimensão alvo correspondente
        $scaleFilter = "scale=$targetWidth:$targetHeight:force_original_aspect_ratio=increase";

        // Depois, corte o vídeo para as dimensões exatas desejadas
        $cropFilter = "crop=$targetWidth:$targetHeight";

        // Comando FFmpeg para redimensionar e cortar o vídeo
        $command = "ffmpeg -y -i $sourcePath -vf \"$scaleFilter, $cropFilter\" $tempPath 2>&1";
        exec($command, $output, $return_var);

        // Captura e exibe a saída completa do FFmpeg
        $outputMessage = implode("\n", $output);

        // Log detalhado do comando e da saída
        file_put_contents('ffmpeg_log.txt', "Command: $command\n\nOutput:\n$outputMessage");

        if ($return_var != 0) {
            return ['msg' => 'Erro ao redimensionar e cortar o vídeo: ' . $outputMessage];
        }

        // Renomear o arquivo temporário para substituir o original
        if (!rename($tempPath, $sourcePath)) {
            return ['msg' => 'Não foi possível renomear o arquivo temporário para o caminho original.'];
        }
        return true;
    }
}
