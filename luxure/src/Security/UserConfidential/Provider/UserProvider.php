<?php

declare(strict_types=1);

namespace App\Security\UserConfidential\Provider;

use App\Document\Usuario\User;
use App\Service\Edicao\ManipuladoresMensagem\EnvioExcecao;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class UserProvider implements UserProviderInterface
{

    public function __construct(
        private RequestStack $requestStack,
        private DocumentManager $dm,
        private MemcachedSessionHandler $memcached,
        private EnvioExcecao $envioExcecao
    ) {
    }

    public function loadUserByIdentifier($email): UserInterface
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        if ($session->has('user_log')) {
            $user = $session->get('user_log');
            $session->remove('user_log');
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        throw new CustomUserMessageAuthenticationException('Divergências encontradas entre a sessão do usuário autenticado e seu passaporte!');
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        $request = $this->requestStack->getCurrentRequest();

        $s_atual = $user->getId();

        if ($request->getSession()->has('primeiro')) {

            if (!$this->memcached->validateId($s_atual)) {

                $this->memcached->write($s_atual, serialize([$request->cookies->all()]));
            } else {

                $user_antigo = unserialize($this->memcached->read($s_atual));

                $this->envioExcecao->setWebhook(

                    $user->getInformacoes()->getEdicoesAtualizadas()->getIdJwt(),
                    'Você fez login em outro dispositivo. Continue sua sessão por lá.'
                );

                $this->memcached->destroyEspecified($user_antigo[0]['PHPSESSID']);

                $this->memcached->write($s_atual, serialize([$request->cookies->all()]));
            }
            $request->getSession()->remove('primeiro');
        }
        
        return $user;
    }


    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): bool
    {
        try {

            $dateTime = new DateTime();
            $user->getInformacoes()->getAlteracoes()->setAlteracaoSenha($dateTime);

            $this->dm->createQueryBuilder(User::class)
                ->findAndUpdate()
                ->field('email')->equals($user->getEmail())

                ->field('password')->set($newHashedPassword)
                ->field('informacoes')->set($user->getInformacoes())
                ->getQuery()
                ->execute();

            $user->setPassword($newHashedPassword);
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
                    'Houve algum problema durante o salvamento da nova senha do usuário no banco de dados'
                );
            });
            captureException($e);
            return false;
        }
    }

}
