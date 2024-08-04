<?php

namespace App\Document\Usuario\Embeded\InfoAdicionais\Edicoes;

use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;

#[EmbeddedDocument]
class EdicoesAtualizadas
{

    #[Field(type: 'bool')]
    private ?bool $status = null;

    #[Field(type: 'int')]
    private ?int $qtd = null;

    #[Field(type: 'bool')]
    private ?bool $capa = null;

    #[Field(type: 'string')]
    private ?string $id_jwt = null;

    #[Field(type: 'string')]
    private ?string $base = null;

    #[Field(type: 'string')]
    private ?bool $primeiro_envio = null;
    
    public function getStatus(): bool
    {
        return $this->status;
    }
    
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
    public function getQtd(): int
    {
        return $this->qtd;
    }
    
    public function setQtd(int $qtd): void
    {
        $this->qtd = $qtd;
    }

    public function getCapa(): bool
    {
        return $this->capa;
    }
    
    public function setCapa(bool $capa): void
    {
        $this->capa = $capa;
    }

    public function getIdJwt(): string
    {
        return $this->id_jwt;
    }
    
    public function setIdJwt(string $id_jwt): void
    {
        $this->id_jwt = $id_jwt;
    }

    public function getBase(): string
    {
        return $this->base;
    }
    
    public function setBase(string $base): void
    {
        $this->base = $base;
    }

    public function getPrimeiroEnvio(): ?bool
    {
        return $this->primeiro_envio;
    }
    
    public function setPrimeiroEnvio(?bool $primeiro_envio): void
    {
        $this->primeiro_envio = $primeiro_envio;
    }

}