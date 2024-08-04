<?php

namespace App\Document\Usuario\Embeded\InfoAdicionais\Alteracoes;

use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;

#[EmbeddedDocument]
class Alteracoes
{
    
    #[Field(type: 'date')]
    private ?\DateTime $alteracao_nascimento = null;

    #[Field(type: 'date')]
    private ?\DateTime $alteracao_email = null;
    
    #[Field(type: 'date')]
    private ?\DateTime $alteracao_username = null;
    
    #[Field(type: 'date')]
    private ?\DateTime $alteracao_senha = null;

    #[Field(type: 'date')]
    private ?\DateTime $alteracao_celular = null;

    #[Field(type: 'date')]
    private ?\DateTime $alteracao_alcunha = null;

    public function getAlteracaoNascimento(): ?\DateTime
    {
        return $this->alteracao_nascimento;
    }

    public function setAlteracaoNascimento(?\DateTime $alteracao_nascimento): void
    {
        $this->alteracao_nascimento = $alteracao_nascimento;
    }

    public function getAlteracaoEmail(): ?\DateTime
    {
        return $this->alteracao_email;
    }
    
    public function getAlteracaoUsername(): ?\DateTime
    {
        return $this->alteracao_username;
    }

    public function setAlteracaoUsername(?\DateTime $alteracao_username): void
    {
        $this->alteracao_username = $alteracao_username;
    }

    public function setAlteracaoEmail(?\DateTime $alteracao_email): void
    {
        $this->alteracao_email = $alteracao_email;
    }
    public function getAlteracaoCelular(): ?\DateTime
    {
        return $this->alteracao_celular;
    }

    public function setAlteracaoCelular(?\DateTime $alteracao_celular): void
    {
        $this->alteracao_celular = $alteracao_celular;
    }

    public function getAlteracaoAlcunha(): ?\DateTime
    {
        return $this->alteracao_alcunha;
    }

    public function setAlteracaoAlcunha(?\DateTime $alteracao_alcunha): void
    {
        $this->alteracao_alcunha = $alteracao_alcunha;
    }
    
    public function getAlteracaoSenha(): ?\DateTime
    {
        return $this->alteracao_senha;
    }

    public function setAlteracaoSenha(?\DateTime $alteracao_senha): void
    {
        $this->alteracao_senha = $alteracao_senha;
    }
}