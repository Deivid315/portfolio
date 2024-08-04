<?php

declare(strict_types=1);

namespace App\Security\TrocarSenha;

use App\Repository\UserAuthenticate\AuthenticateRepository;
use App\Service\Email\EnviarEmailMailer;
use App\Service\Token\TokenGenerator;
use DateTime;
use Symfony\Component\Form\FormInterface;

class ValidacaoSenha extends TokenGenerator
{
    public function __construct(
        private AuthenticateRepository $repository,
        private EnviarEmailMailer $enviarEmail
    ) {
    }
    public function valida(string $email): array
    {

        $now = new DateTime();
        $classetoken = new TokenGenerator;
        $msg = $classetoken->gereToken($email);

        $troque = $this->repository->troque($email, $now, $msg);

        if ($troque === true) {

            $destino = $email;
            $titulo = 'Alteração de Senha';
            $html = '<p><a href="http://localhost:8000/login/trocar-senha/form/' . $msg . '">Clique aqui para alterar sua senha</a></p>';

            $envio = $this->enviarEmail->enviar($destino, $titulo, $html);

            if (!$envio) {
                return ['erro' => 'Houve um erro em nossos serviços. Por favor tente resuperar sua senha mais tarde.'];
            }

            return ['sucesso' => true];
        } else if(!$troque){
            return ['sucesso' => true];
        }else{
            return ['erro' => 'Houve um erro em nossos serviços. Por favor tente resuperar sua senha mais tarde.'];
        }
    }
}
