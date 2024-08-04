<?php

declare(strict_types=1);

namespace App\Security\UserConfidential\Cadastro;

use App\Document\Usuario\User;
use App\Repository\UserAuthenticate\AuthenticateRepository;
use App\Service\Email\EnviarEmailMailer;
use App\Service\Token\TokenGenerator;
use DateTime;
use Firebase\JWT\JWT;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Processos
{
    public function __construct(
        private UserPasswordHasherInterface $pass,
        private EnviarEmailMailer $envio,
        private TokenGenerator $token,
        private AuthenticateRepository $auth
    ) {
    }
    public function check(User $user): true|array
    {
        $salvamento = $this->auth->emailValid($user->getEmail());
        if (is_bool($salvamento) && $salvamento) {

            $expiracao = new DateTime();
            $dateTime = new DateTime();

            $user->setCriacaoDaConta($dateTime);
            $hashed = $this->pass->hashPassword($user, $user->getPassword());
            $user->setPassword($hashed);
            $user->setRoles(['ROLE_USER_N1']);
            $msg = $this->token->gereToken($user->getEmail(), $user->getAlcunha());

            $user->getValidacaoDaConta()->setConfirmacaoDeEmail($dateTime);
            $user->getValidacaoDaConta()->setChave($msg);
            $user->getValidacaoDaConta()->setStatus(false);
            $user->getValidacaoDaConta()->setExpiracao($expiracao);

            $user->setStatus('PENDENTE_CONF_EMAIL');

            $b64 = hash('SHA256', $user->getEmail());
            $encryptedPhpsessid = base64_encode(sodium_crypto_generichash(base64_encode($b64), '', 40));
            $emissao = $this->emitirToken($encryptedPhpsessid);

            $user->getInformacoes()->getEdicoesAtualizadas()->setQtd(0);
            $user->getInformacoes()->getEdicoesAtualizadas()->setCapa(false);
            $user->getInformacoes()->getEdicoesAtualizadas()->setStatus(false);
            $user->getInformacoes()->getEdicoesAtualizadas()->setIdJwt($emissao);
            $user->getInformacoes()->getEdicoesAtualizadas()->setBase($b64);

            $user->setSelecionado(false);

            $this->auth->emailValid($user->getEmail(), false, $user);

            $destino = $user->getEmail();
            $titulo = 'Confirmação para Conta de Cadastro';
            $html = '<p><a href="http://localhost:8000/confirm/' . $msg . '">Clique aqui para confirmar seu Email</a></p>';

            $envio = $this->envio->enviar($destino, $titulo, $html, true);
            if (!$envio) {
                return ['erro' => 'Houve um erro em nossos serviços. Por favor tente criar sua conta novamente mais tarde.'];
            }
            return true;
        } else if (is_bool($salvamento) && !$salvamento) {
            return ['erro' => 'Esse email já existe em nossa base dados, por favor faça login.'];
        } else if (is_array($salvamento) && isset($salvamento['erro'])) {
            return $salvamento;
        }
    }

    private function emitirToken(string $email): string
    {

        $secretKey = $_ENV['KEY_JWT'];
        $payload = [
            'iss' => 'http://localhost:8000/user/painel',
            'aud' => 'http://localhost:8000/user/painel',
            'iat' => time(),
            'nbf' => time(),
            'data' => [
                'cod' => $email,
            ]
        ];

        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        return json_encode(['token' => $jwt]);
    }
}
