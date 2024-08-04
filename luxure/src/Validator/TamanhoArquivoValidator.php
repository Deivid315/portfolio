<?php
// src/Validator/TamanhoArquivoValidator.php
namespace App\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TamanhoArquivoValidator extends ConstraintValidator
{
    public function validate($arquivo, Constraint $constraint)
    {
        if (!$constraint instanceof TamanhoArquivo) {
            return;
        }

        if (!$arquivo instanceof UploadedFile) {
            return;
        }
        
        if (null === $arquivo) {
            return;
        }


        $imagemExtensoes = ["jpeg", "jpg", "png", "heic"];
        $videoExtensoes = ["mp4", "webm", "mov"];
        $imagemMimeTypes = ["image/jpeg", "image/png", "image/heic"];
        $videoMimeTypes = ["video/mp4", "video/webm", "video/quicktime"];

        $extensao = strtolower($arquivo->getClientOriginalExtension());
        $mimeType = $arquivo->getMimeType();
        $tamanho = $arquivo->getSize();

        if (in_array($extensao, $imagemExtensoes) && in_array($arquivo->guessExtension(), $imagemExtensoes)) {
            if (in_array($mimeType, $imagemMimeTypes)) {
                if ($tamanho > 10000000) {
                    $tamanhoFormatado = round($tamanho / 1000000, 1) . ' Mb';
                    $this->context->buildViolation($constraint->tamanho_imagem)
                        ->setParameter('{{ name }}', $arquivo->getClientOriginalName())
                        ->setParameter('{{ tamanho }}', $tamanhoFormatado)
                        ->addViolation();
                }
            } else {
                $this->context->buildViolation($constraint->mime_imagem)
                    ->setParameter('{{ name }}', $arquivo->getClientOriginalName())
                    ->addViolation();
            }
        } elseif (in_array($extensao, $videoExtensoes) && in_array($arquivo->guessExtension(), $videoExtensoes)) {
            if (in_array($mimeType, $videoMimeTypes)) {
                if ($tamanho > 100000000) {
                    $tamanhoFormatado = round($tamanho / 1000000, 1) . ' Mb';
                    $this->context->buildViolation($constraint->tamanho_video)
                        ->setParameter('{{ name }}', $arquivo->getClientOriginalName())
                        ->setParameter('{{ tamanho }}', $tamanhoFormatado)
                        ->addViolation();
                }
            } else {
                $this->context->buildViolation($constraint->mime_video)
                    ->setParameter('{{ name }}', $arquivo->getClientOriginalName())
                    ->addViolation();
            }
        } else {
            if (in_array($extensao, $imagemExtensoes)) {
                $this->context->buildViolation($constraint->extensao_imagem)
                    ->setParameter('{{ name }}', $arquivo->getClientOriginalName())
                    ->addViolation();
            } elseif (in_array($extensao, $videoExtensoes)) {
                $this->context->buildViolation($constraint->extensao_video)
                    ->setParameter('{{ name }}', $arquivo->getClientOriginalName())
                    ->addViolation();
            }
        }
    }
}
