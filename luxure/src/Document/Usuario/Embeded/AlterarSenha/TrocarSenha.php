<?php

namespace App\Document\Usuario\Embeded\AlterarSenha;

use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Index;

#[EmbeddedDocument]
class TrocarSenha
{
    #[Field(name: 'data', type: 'date')]
    private ?\DateTime $data;
    
    #[Field(name: 'codigo', type: 'string')]
    private ?string $codigo;

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): void
    {
        $this->codigo = $codigo;
    }

    public function getData(): ?\DateTime
    {
        return $this->data;
    }

    public function setData(?\DateTime $data): void
    {
        $this->data = $data;
    }

}