<?php

namespace App\Document\Usuario\Embeded\ValidacaoConta;

use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Index;

#[EmbeddedDocument]
class ValidacaoDaConta
{
    #[Field(name: 'confirmacao_de_email', type: 'date')]
    private \DateTime $confirmacao_de_email;
    
    #[Field(name: 'chave', type: 'string')]
    private ?string $chave;
    
    #[Field(name: 'status', type: 'bool')]
    private bool $status;
    
    #[Field(name: 'expiracao', type: 'date')]
    private ?\DateTime $expiracao;

    public function getChave(): string
    {
        return $this->chave;
    }

    public function setChave(?string $chave): void
    {
        $this->chave = $chave;
    }

    public function getConfirmacaoDeEmail(): \DateTime
    {
        return $this->confirmacao_de_email;
    }

    public function setConfirmacaoDeEmail(\DateTime $confirmacao_de_email): void
    {
        $this->confirmacao_de_email = $confirmacao_de_email;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function setExpiracao(?\DateTime $expiracao): void
    {
        $this->expiracao = $expiracao;
    }

}