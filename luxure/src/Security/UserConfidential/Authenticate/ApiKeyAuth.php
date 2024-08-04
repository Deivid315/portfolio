<?php

declare(strict_types=1);

namespace App\Security\UserConfidential\Authenticate;

use App\Document\Usuario\User;
use App\Repository\UserAuthenticate\AuthenticateRepository;
use App\Service\Email\EnviarEmailMailer;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuth extends AbstractAuthenticator
{

    public int $tentativas = 4;

    public function __construct(
        private RateLimiterFactory $loginAttemptsLimiter,
        private AuthenticateRepository $repository,
        private EnviarEmailMailer $envio,
        private CsrfTokenManagerInterface $csrf
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->request->has('_username') &&
            $request->request->has('_password') &&
            $this->csrf->isTokenValid(new CsrfToken('authenticate', $request->request->get('_csrf_token')));
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('_username') ?? '';
        $senha = $request->request->get('_password') ?? '';

        if (
            !empty($email) &&
            !empty($senha) &&
            $request->request->has('_password') &&
            $request->request->has('_username') &&
            strlen($senha) >= 8 &&
            strlen($senha) <= 100 &&
            strlen($email) <= 100 &&
            preg_match('/^[a-zA-Z0-9._%±]+@[a-zA-Z0-9.±]+\.[a-zA-Z]{2,}$/', $email)
        ) {

            $userIdentifier = $this->repository->verificarEmailSenhaLogin($email, $senha);
            $remainingAttempts = $this->limit($request);

            if (is_array($userIdentifier) && isset($userIdentifier['msg'])) {

                if ($remainingAttempts <= 3) {
                    throw new CustomUserMessageAuthenticationException(
                        "{$userIdentifier['msg']} " . PHP_EOL .
                            "Você está tentando fazer login muitas vezes. Em {$remainingAttempts}
                         tentativa(s) seu acesso será bloqueado por determinado tempo"
                    );
                }
                throw new CustomUserMessageAuthenticationException($userIdentifier['msg']);
            }

            if (is_array($userIdentifier) && isset($userIdentifier['erro'])) {
                if ($remainingAttempts <= 3) {
                    throw new CustomUserMessageAuthenticationException("{$userIdentifier['erro']} "
                        . PHP_EOL . "Você está tentando fazer login muitas
                      vezes, em {$remainingAttempts} 
                    tentativa(s) seu acesso será bloqueado por determinado tempo");
                }
                throw new CustomUserMessageAuthenticationException($userIdentifier['erro']);
            }

            if (is_array($userIdentifier) && isset($userIdentifier['email'])) {
                $email = $userIdentifier['email'];

                if (isset($userIdentifier['token'])) {

                    $destino = $email;
                    $titulo = 'Confirmação de Conta';
                    $html = '<p><a href="http://localhost:8000/confirm/' . $userIdentifier['token'] . '">Clique aqui para confirmar seu Email</a></p>';

                    $envio = $this->envio->enviar($destino, $titulo, $html);

                    if (!$envio) {
                        throw new CustomUserMessageAuthenticationException("A conta {$email} ainda não foi confirmada, infelizmente houve
                        um erro em nossos serviços e não possível reenviar um link de confirmação, tente novamente mais tarde.");
                    }

                    if ($remainingAttempts <= 3) {

                        throw new CustomUserMessageAuthenticationException("A conta {$email} ainda não foi 
                        verificada, acesse seu email e clique no link de verificação que acabou de ser enviado.
                        Após confirmada tente fazer login novamente." . PHP_EOL . " OBS: Você está tentando fazer login muitas 
                        vezes, em  {$remainingAttempts} tentativa(s) seu acesso será bloqueado por 
                        determinado tempo");
                    }
                    throw new CustomUserMessageAuthenticationException("A conta {$email} ainda não foi 
                    verificada, acesse seu email e clique no link de verificação que acabou de ser enviado.
                    Após confirmada tente fazer login novamente.");
                } else if (isset($userIdentifier['tempo'])) {
                    $falta = 300 - $userIdentifier['tempo'];
                    $tempo = $falta < 60 ? $falta . ' segundos' : floor($falta / 60) . ' minuto(s)';
                    throw new CustomUserMessageAuthenticationException("Já enviamos anteriormente um link
                    de confirmação para a conta {$userIdentifier['email']}, aguarde {$tempo} para o reenvio.");
                }
            }

            if ($userIdentifier instanceof User) {

                if ($remainingAttempts <= 3) {
                    throw new CustomUserMessageAuthenticationException("Você está tentando fazer 
                    login muitas vezes, em {$remainingAttempts} tentativa(s) seu acesso será bloqueado por determinado tempo");
                }

                $session = $request->getSession();
                $session->set('user_log', $userIdentifier);
                return new SelfValidatingPassport(new UserBadge($userIdentifier->getEmail()));
            }
        } else {
            throw new CustomUserMessageAuthenticationException('Email ou senha incorretos.');
        }
    }

    private function limit(Request $request): int
    {
        $limiter = $this->loginAttemptsLimiter->create($request->getClientIp());
        $limiter->reset();
        $limit = $limiter->consume(1);
        if (false === $limit->isAccepted()) {
            throw new CustomUserMessageAuthenticationException('Você tentou fazer login muitas vezes! Tente novamente mais tarde!');
        }
        return $limit->getRemainingTokens();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $request->getSession()->set('primeiro', true);
        $resposta = new RedirectResponse('/user/painel');
        $resposta->headers->setCookie(
            Cookie::create(
                'base',
                $token->getUser()->getInformacoes()->getEdicoesAtualizadas()->getBase(),
                time() + 86400,
                httpOnly: false
            )
        );

        $resposta->headers->setCookie(
            Cookie::create(
                'id_',
                $token->getUser()->getInformacoes()->getEdicoesAtualizadas()->getIdJwt(),
                time() + 86400,
                httpOnly: false
            )
        );
        return $resposta;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        $request->getSession()->getFlashBag()->add('message', $message);
        return new RedirectResponse('/login');
    }
}
