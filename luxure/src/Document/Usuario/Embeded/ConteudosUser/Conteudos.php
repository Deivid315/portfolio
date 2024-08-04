<?php

namespace App\Document\Usuario\Embeded\ConteudosUser;

use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;

#[EmbeddedDocument]
class Conteudos
{
    
    #[Field(type: 'hash')]
    private ?array $arquivos_privados = [];

    #[Field(type: 'hash')]
    private ?array $arquivos_publicos;

    #[Field(type: 'hash')]
    private ?array $notificacoes = [];

    #[Field(type: 'string')]
    private ?string $foto_validacao = null;
    
    #[Field(type: 'hash')]
    private ?array $atuacao = null;

    public function getArquivosPrivados(): ?array
    {
        if (empty($this->arquivos_privados)) {
            return null;
        } else {
            return $this->arquivos_privados;
        }
    }

    public function setArquivosPrivados(array $arquivos_privados): void
    {
        $this->arquivos_privados = $arquivos_privados;
    }

    public function getArquivosPublicos(): ?array
    {
        if (empty($this->arquivos_publicos)) {
            return null;
        } else {
            return $this->arquivos_publicos;
        }
    }

    public function setArquivosPublicos(array $arquivos_publicos): void
    {
        $this->arquivos_publicos = $arquivos_publicos;
    }

    public function getNotificacoes(): ?array
    {
        return $this->notificacoes;
    }

    public function setNotificacoes(?string $notificacoes): void
    {
        if($notificacoes === null){
            $this->notificacoes = [];
        }else{
            $this->notificacoes[] = $notificacoes;
        }
    }

    public function getValidacao(): string
    {
        return $this->foto_validacao;
    }

    public function setValidacao(string $foto_validacao): void
    {
        $this->foto_validacao = $foto_validacao;
    }

    public function getAtuacao(): array
    {
        return $this->atuacao;
    }

    public function setAtuacao(array $atuacao): void
    {
        $this->atuacao = $atuacao;
    }

}