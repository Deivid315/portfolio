<?php

declare(strict_types=1);

namespace App\Service\Email;

use App\Repository\UserAuthenticate\AuthenticateRepository;
use Exception;
use Sentry\State\Scope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use function Sentry\captureException;
use function Sentry\configureScope;

class EnviarEmailMailer
{

    public function __construct(
        private AuthenticateRepository $authenticateRepository,
        private MailerInterface $mailer
    ) {
    }

    public function enviar(string $destino, string $titulo, string $html, bool $exclusao = false): bool
    {
        try {

            $email = (new Email())
                ->from('contato@magnossites.com')
                ->to($destino)
                ->subject($titulo)
                ->html($html);

            $this->mailer->send($email);

            return true;
        } catch (\Throwable $e) {
            if ($exclusao) {
                configureScope(function (Scope $scope) use ($e) {
                    $scope->setExtra('informacao_adicional', 'Não foi possível enviar o email para validação de conta ao usuário,
                    portanto a conta recém criada será excluída do bd.');
                });
                captureException($e);
                $this->authenticateRepository->emailValid($destino, true);
                return false;
            }
            configureScope(function (Scope $scope) use ($e) {
                $scope->setExtra('informacao_adicional', 'Não foi possível enviar o email');
            });
            captureException($e);
            return false;
        }
    }
}
