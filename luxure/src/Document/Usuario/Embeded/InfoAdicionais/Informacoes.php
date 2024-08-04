<?php

namespace App\Document\Usuario\Embeded\InfoAdicionais;

use App\Document\Usuario\Embeded\InfoAdicionais\Alteracoes\Alteracoes;
use App\Document\Usuario\Embeded\InfoAdicionais\Edicoes\EdicoesAtualizadas;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbedOne;

#[EmbeddedDocument]
class Informacoes
{
    
    #[EmbedOne(targetDocument: Alteracoes::class)]
    private ?Alteracoes $alteracoes = null;
    
    #[EmbedOne(targetDocument: EdicoesAtualizadas::class)]
    private ?EdicoesAtualizadas $edicoes_atualizadas = null;

    public function getAlteracoes(): ?Alteracoes
    {
        if ($this->alteracoes === null) {
            $this->alteracoes = new Alteracoes();
        }
        return $this->alteracoes;
    }

    public function setAlteracoes(Alteracoes $alteracoes): void
    {
        $this->alteracoes = $alteracoes;
    }

    public function getEdicoesAtualizadas(): ?EdicoesAtualizadas
    {
        if ($this->edicoes_atualizadas === null) {
            $this->edicoes_atualizadas = new EdicoesAtualizadas();
        }
        return $this->edicoes_atualizadas;
    }

    public function setEdicoesAtualizadas(EdicoesAtualizadas $edicoes_atualizadas): void
    {
        $this->edicoes_atualizadas = $edicoes_atualizadas;
    }

}