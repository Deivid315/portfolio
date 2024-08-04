<?php

declare(strict_types=1);

namespace App\Repository\UserAuthenticate;

use App\Document\Usuario\User;
use App\MessageHandler\ExcecaoMsg;
use App\Service\Token\TokenGenerator;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use Sentry\State\Scope;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class AuthenticateRepository
{
    public function __construct(
        private TokenGenerator $token,
        private DocumentManager $dm,
        private UserPasswordHasherInterface $pass,
    ) {
    }

    public function refresh($email, $senha): bool
    {

        $repository = $this->dm->createQueryBuilder(User::class)
            ->field('email')->equals($email);

        $query = $repository->getQuery();
        $result = $query->getSingleResult();


        if ($result) {
            if ($result->getPassword() === $senha) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function troque(string $email, \DateTime $data, string $codigo): ?bool
    {
        try {
            $retorno = $this->dm->createQueryBuilder(User::class)
                ->findAndUpdate()
                ->field('email')->equals($email)

                ->field('trocar_senha.codigo')->set($codigo)
                ->field('trocar_senha.data')->set($data)
                ->getQuery()
                ->execute();

            return $retorno !== null;
        } catch (\Throwable $e) {
            $this->catch($e, 'houve um problema durante a criação do campo trocar_senha do usuário');
            return null;
        }
    }

    public function confirmUsername(string $username): bool
    {
        $queryBuilder = $this->dm->createQueryBuilder(User::class)
            ->field('username')->equals($username)
            ->getQuery()
            ->execute();
    
        return $queryBuilder->count() > 0;
    }

    public function emailValid(string $credential, bool $deletar = false, ?User $user = null): bool|array
    {
        try {
            if ($deletar) {
                $this->dm->createQueryBuilder(User::class)
                    ->remove()
                    ->field('email')->equals($credential)
                    ->getQuery()
                    ->execute();
                return true;
            } else if (empty($user)) {
                $repository = $this->dm->getRepository(User::class);
                $result = $repository->findOneBy(['email' => $credential]);
                return $result === null;
            } else {
                $this->dm->persist($user);
                $this->dm->flush();
                return true;
            }
        } catch (\Throwable $e) {
            $this->catch($e, 'erro');
            return ['erro' => 'Houve um problema em nossos serviços, tente novamente mais tarde.'];
        }
    }

    //função pra verificar se o email do usuário existe e se a senha é a mesma do login
    public function verificarEmailSenhaLogin(string $email, string $token): array|User
    {
        try {
            $result = $this->dm->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($result !== null) {
                //verificar se a senha inserida está correta com a do banco de dados
                if ($this->pass->isPasswordValid($result, $token)) {
                    if ($result->getValidacaoDaConta()->getStatus() === true) {

                        if ($result->getStatus() !== 'AGUARDANDO_ENVIO_ARQS') {
                            $fotosEVideos = $result->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'];
                            if (count($fotosEVideos) > 11 || count($fotosEVideos) < 2) {
                                throw new ExcecaoMsg();
                            }
                        }
                        return $result;
                    } else {

                        $criacao = $result->getValidacaoDaConta()->getConfirmacaoDeEmail();
                        $atual = new \DateTime();
                        $segundos = $atual->getTimestamp() - $criacao->getTimestamp();

                        if ($segundos > 300) {

                            //conta ainda não foi confirmada
                            $msg = $this->token->gereToken($result->getEmail(), $result->getAlcunha());
                            $data = new \DateTime();
                            $expiracao = new \DateTime();
                            $result->getValidacaoDaConta()->setConfirmacaoDeEmail($data);
                            $result->getValidacaoDaConta()->setChave($msg);
                            $result->getValidacaoDaConta()->setStatus(false);
                            $result->getValidacaoDaConta()->setExpiracao($expiracao);
                            $this->dm->persist($result);
                            $this->dm->flush();
                            return ['email' => $result->getEmail(), 'token' => $msg];
                        } else {
                            return ['email' => $result->getEmail(), 'tempo' => $segundos];
                        }
                    }
                } else {
                    //return ['msg' => 'senha errada'];
                    return ['msg' => 'Email ou senha incorretos.'];
                }
            } else {
                //return ['msg' => 'não existe'];
                return ['msg' => 'Email ou senha incorretos.'];
            }
        } catch (ExcecaoMsg $w) {
            configureScope(function (Scope $scope) use ($w, $result): void {
                $scope->setUser(
                    [
                        'nome_completo' => $result->getNomeCompleto(),
                        'telefone' => $result->getCelular(),
                        'email' => $result->getEmail(),
                        'roles' => json_encode($result->getRoles()),
                        'status' => $result->getStatus()
                    ]
                );
                $scope->setExtra('informacao_adicional', 'O usuáio possui mais de 11 arquivos no perfil ou menos que 2
                 e já confirmou a conta, ou seja, não tá mais com o status de AGUARDANDO_ENVIO_ARQS');
            });
            captureException($w);
            return ['erro' => 'Houve um erro no processamento da sua conta. Nossa equipe já está verificando isso e 
            em breve entraremos em contato via e-mail. Sentimos muito pelo incômodo'];
        } catch (\Throwable $m) {
            configureScope(function (Scope $scope) use ($m): void {
                $scope->setExtra('informacao_adicional', 'Houve um erro durante a confirmação do usuário
                na tela de login ');
            });
            captureException($m);
            return ['erro' => 'Lamentamos pelo ocorrido mas houve um problema em nossos serviços, tente novamente mais tarde.'];
        }
    }

    public function trocarsenha($value): ?object
    {

        $qb = $this->dm->createQueryBuilder(User::class)
            ->field('trocarsenha.codigo')->equals($value)
            ->select('trocarsenha', 'password', 'email');

        $query = $qb->getQuery();
        $user = $query->getSingleResult();
        if ($user) {
            $criacao = $user->getTrocarSenha()->getData();
            $atual = new DateTime();
            $segundos = $atual->getTimestamp() - $criacao->getTimestamp();

            if ($segundos <= 3600) {

                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function linkSenha(string $codigo): ?bool
    {
        try {

            $user = $this->dm->createQueryBuilder(User::class)
                ->field('trocar_senha.codigo')->equals($codigo)
                ->select('trocar_senha', 'email')
                ->getQuery()
                ->getSingleResult();

            if (is_object($user)) {

                $envio = $user->getTrocarSenha()->getData();
                $atual = new \DateTime();
                $segundos = $atual->getTimestamp() - $envio->getTimestamp();
                if ($segundos <= 3600) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use ($e): void {
                $scope->setExtra('informacao_adicional', 'Ocorreu um erro durante a verificação do link 
                de trocar senha');
            });
            captureException($e);
            return null;
        }
    }

    public function confirmSenha(string $codigo, string $senha): null|bool|string
    {
        try {

            $user = $this->dm->createQueryBuilder(User::class)
                ->field('trocar_senha.codigo')->equals($codigo)
                ->select('email', 'password', 'trocar_senha')
                ->getQuery()
                ->getSingleResult();

            if (!empty($user)) {

                $envio = $user->getTrocarSenha()->getData();
                $atual = new \DateTime();
                $segundos = $atual->getTimestamp() - $envio->getTimestamp();

                if ($segundos <= 3600) {
                    $senha_cripto = $this->pass->hashPassword($user, $senha);
                    $user->setPassword($senha_cripto);
                    $user->setTrocarSenha(null);
                    $this->dm->persist($user);
                    $this->dm->flush();

                    return $user->getEmail();
                } else {
                    $user->setTrocarSenha(null, null);
                    $this->dm->persist($user);
                    $this->dm->flush();
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use ($e): void {
                $scope->setExtra('informacao_adicional', 'Ocorreu um erro durante a alteração 
                da senha do usuário após a confirmação do link de recuperação de senha.');
            });
            captureException($e);
            return null;
        }
    }

    private function catch(object $excecao, string $informacao): void
    {
        configureScope(function (Scope $scope) use ($excecao, $informacao): void {
            $scope->setExtra('informacao_adicional', $informacao);
        });
        captureException($excecao);
    }
}
