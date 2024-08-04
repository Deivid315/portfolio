<?php

declare(strict_types=1);

namespace App\Document\Modificacao;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'atualizacao')]
class Atualizacao
{
    #[MongoDB\Id(strategy: 'NONE')]
    private int $id = 1;

    #[MongoDB\Field(type: 'date')]
    private DateTime $atual;

    public function getId()
    {
        return $this->id;
    }
    
    public function getAtual(): DateTime
    {
        return $this->atual;
    }

    public function setAtual(DateTime $atual): void
    {
        $this->atual = $atual;
    }
}