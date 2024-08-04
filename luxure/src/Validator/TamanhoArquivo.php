<?php

// src/Validator/FileSize.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TamanhoArquivo extends Constraint
{
    public $tamanho_imagem = 'A imagem {{ name }} possui {{ tamanho }} porém o tamanho máximo permitido é 10Mb.';
    public $tamanho_video = 'O vídeo {{ name }} possui {{ tamanho }} porém o tamanho máximo permitido é 100Mb.';
   
    public $mime_imagem = 'O tipo MIME da imagem {{ name }} não corresponde ao seu conteúdo real, por motivos de segurança seu envio será bloqueado.';
    public $mime_video = 'O tipo MIME do vídeo {{ name }} não corresponde ao seu conteúdo real, por motivos de segurança seu envio será bloqueado.';
   
    public $extensao_imagem = 'A extensão da imagem {{ name }}  não confere com seu conteúdo.';
    public $extensao_video = 'A extensão do vídeo {{ name }} não confere com seu conteúdo.';
}
