<?php

namespace App\Message\EditarConta;

use Symfony\Component\Security\Core\User\UserInterface;

class PrimeiroEnvioMessage
{
    public function __construct(
        private array $edicao_serializado,
        private UserInterface $user,
        private array $detalhes,
        private string $uid,
        private string $username
    ) {
    }

    public function getEdicaoSerializado(): array
    {
        return $this->edicao_serializado;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getDetalhes(): array
    {
        return $this->detalhes;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}