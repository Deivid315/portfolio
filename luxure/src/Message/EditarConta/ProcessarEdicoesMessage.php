<?php

// src/Message/SmsNotification.php
namespace App\Message\EditarConta;

use Symfony\Component\Security\Core\User\UserInterface;

class ProcessarEdicoesMessage
{
    public function __construct(
        private array $array_heic_mov,
        private UserInterface $userint,
        private ?array $edicao_serializado,
        private ?array $arq_alt,
        private int|array $remov_sep,
        private string $u_id_chave
    ) {
    }

    public function getArrayHeicMov(): array
    {
        return $this->array_heic_mov;
    }

    public function getUserint(): UserInterface
    {
        return $this->userint;
    }

    public function getEdicaoSerializado(): ?array
    {
        return $this->edicao_serializado;
    }
    
    public function getRemovidos(): int|array
    {
        return $this->remov_sep;
    }

    public function getUId(): string
    {
        return $this->u_id_chave;
    }

    public function getArqAlt(): ?array
    {
        return $this->arq_alt;
    }

}