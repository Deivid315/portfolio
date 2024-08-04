<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class KernelRequestListener implements EventSubscriberInterface
{
    public function __construct(
        private MemcachedSessionHandler $memcached,
        private TokenStorageInterface $tokenStorageInterface,
        private RequestStack $requestStack,
        private LoggerInterface $logger,
        private Security $security
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->security->getUser();
        if (!$user) {
            return;
        }

        $this->logger->info('roles', $user->getRoles());

        $edicoesAtualizadas = $user->getInformacoes()->getEdicoesAtualizadas();
        $conteudos = $user->getConteudosDaConta();

        if ($edicoesAtualizadas->getStatus() || $edicoesAtualizadas->getPrimeiroEnvio() !== null) {


            if ($this->memcached->validateId($user->getId() . '_atualizacao')) {

                $this->logger->info('existe no memcached');
                $edicoesAtualizadas->setQtd(0);
                $edicoesAtualizadas->setCapa(false);
                $edicoesAtualizadas->setStatus(false);

                $novos_dados = unserialize($this->memcached->read($user->getId() . '_atualizacao'));
                if (isset($novos_dados['arquivos_publicos'])) {

                    $user->getConteudosDaConta()->setArquivosPublicos([
                        'fotosevideos' => $novos_dados['arquivos_publicos']['fotosevideos'],
                        'detalhes' => $novos_dados['arquivos_publicos']['detalhes']
                    ]);
                    $user->getConteudosDaConta()->setArquivosPrivados([]);
                } else if (isset($novos_dados['primeiro_envio'])) {
                    $this->logger->info('primeiro_envio');

                    if (isset($novos_dados['primeiro_envio']['alerta'])) {
                        $this->logger->info('alerta');

                        $edicoesAtualizadas->setPrimeiroEnvio(null);
                        $conteudos->setNotificacoes($novos_dados['primeiro_envio']['alerta']);
                    } else {
                        $this->logger->info('dados');

                        $user->getConteudosDaConta()->setArquivosPublicos([
                            'fotosevideos' => $novos_dados['primeiro_envio']['dados']->getArquivosPublicos()['fotosevideos'],
                            'detalhes' => $novos_dados['primeiro_envio']['dados']->getArquivosPublicos()['detalhes']
                        ]);
                        $user->getConteudosDaConta()->setValidacao($novos_dados['primeiro_envio']['dados']->getValidacao());
                        $edicoesAtualizadas->setPrimeiroEnvio(null);
                        $user->setRoles(['ROLE_USER_N2']);
                        $user->setStatus('ONLINE');

                        $atualize = new UsernamePasswordToken($user, 'main', $user->getRoles());
                        $this->tokenStorageInterface->setToken($atualize);
                        $this->requestStack->getCurrentRequest()->getSession()->set('_security_main', serialize($atualize));
                        $this->logger->info('sucesso');

                        $this->memcached->destroyEspecified($user->getId() . '_atualizacao');

                        $response = new RedirectResponse('/user/painel');
                        $event->setResponse($response);
                    }
                } else {

                    $this->logger->info('erros e alerta');
                    $user->getConteudosDaConta()->setNotificacoes($novos_dados['erros']['alerta']);
                    $user->getConteudosDaConta()->setArquivosPrivados([]);
                }
                $this->logger->info('excluis');

                $this->memcached->destroyEspecified($user->getId() . '_atualizacao');
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
