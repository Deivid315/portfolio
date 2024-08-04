<?php

declare(strict_types=1);

namespace App\Repository\AlteracoesContaDb;

use App\Document\Modificacao\Atualizacao;
use App\Document\Usuario\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sentry\State\Scope;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class AlterarDados
{

    public function __construct(
        private DocumentManager $dm
    ) {
    }
    
    public function alterarUsername(string $username, UserInterface $user): bool
    {

        try {

                $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('username')->equals($user->getUsername())

                    ->field('username')->set($username)
                    ->field("informacoes.alteracoes.alteracao_username")->set($username)
                    ->getQuery()
                    ->execute();

                return true;

        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a alteração do username do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

    public function buscarEmail(string $email, UserInterface $user, object $valid, bool $destrua = false): bool
    {

        try {

            if (!$destrua) {
                $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('email')->equals($user->getEmail())

                    ->field('email')->set($email)
                    ->field('validacao_da_conta.chave')->set($valid->getChave())
                    ->field('validacao_da_conta.confirmacao_de_email')->set($valid->getConfirmacaoDeEmail())
                    ->field('validacao_da_conta.status')->set($valid->getStatus())
                    ->field('informacoes')->set($user->getInformacoes())
                    ->getQuery()
                    ->execute();

                return true;
            } else {
                $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('email')->equals($user->getEmail())

                    ->field('email')->set($email)
                    ->field('validacao_da_conta.chave')->set($valid->getChave())
                    ->field('validacao_da_conta.confirmacao_de_email')->set($valid->getConfirmacaoDeEmail())
                    ->field('validacao_da_conta.status')->set($valid->getStatus())
                    ->field('sessao')->set('')
                    ->field('informacoes')->set($user->getInformacoes())
                    ->getQuery()
                    ->execute();

                return true;
            }
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a alteração do email do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

    public function alteracaoDinamica(
        string $busca,
        string|object $novo,
        UserInterface $user,
        string $getter
    ): bool {

        try {

            $this->dm->createQueryBuilder(User::class)
                ->findAndUpdate()
                ->field('email')->equals($user->getEmail())

                ->field($busca)
                ->set($busca === 'celular' ? intval($novo) : $novo)

                ->field("informacoes.alteracoes.alteracao_{$busca}")
                ->set($user->getInformacoes()->getAlteracoes()->$getter())

                ->getQuery()
                ->execute();

                $this->ultimaAtualizacao();

            return true;
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use (
                $e,
                $user,
                $busca,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a alteração do campo ' . $busca . ' do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

    public function apagarNotificacoesBd(UserInterface $user): bool
    {

        try {

            $this->dm->createQueryBuilder(User::class)
                ->findAndUpdate()
                ->field('email')->equals($user->getEmail())
                ->field("conteudos.notificacoes")->unsetField()
                ->getQuery()
                ->execute();

            return true;
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a deleção
                    de notificacoes do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

    public function offOnContaDb(UserInterface $user, string $status): bool
    {

        try {

            if($status === 'ONLINE'){
                $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('email')->equals($user->getEmail())
                    ->field("status")->set('ONLINE')
                    //->field('informacoes.chave_offline')->unsetField()
                    ->getQuery()
                    ->execute();
            }else{
                $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('email')->equals($user->getEmail())
                    ->field("status")->set('OFFLINE')
                    //->field('informacoes.chave_offline')->set($variavel)
                    ->getQuery()
                    ->execute();
                }
                
                $this->ultimaAtualizacao();

            return true;
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a a atualizaçao dos status da conta
                     do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

    public function deletarContaDb(UserInterface $user): bool
    {

        try {

            $this->dm->createQueryBuilder(User::class)
                ->remove()
                ->field('email')->equals($user->getEmail())
                ->getQuery()
                ->execute();

            return true;
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use (
                $e,
                $user,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $user->getNomeCompleto(),
                        'telefone' => $user->getCelular(),
                        'email' => $user->getEmail(),
                        'roles' => json_encode($user->getRoles()),
                        'status' => $user->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Houve algum problema durante a deleção
                    do documento do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

    private function ultimaAtualizacao(): void
    {
        $atualizacao = new Atualizacao();
        $data = new \DateTime();
        $atualizacao->setAtual($data);
        
        $this->dm->persist($atualizacao);
        $this->dm->flush();
        $this->dm->clear(Atualizacao::class);
    }
}
