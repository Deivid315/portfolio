<?php
// src/EventListener/LogoutSubscriber.php
namespace App\EventListener;

use App\Repository\Uploads\ArquivosRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\VarDumper\VarDumper;

#[AsEventListener]
class LogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private MemcachedSessionHandler $memcached,
        private ArquivosRepository $arquivosRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $user = null;

        if ($event->getToken() !== null) {
            $user = $event->getToken()->getUser();
        }

        $request = $event->getRequest();

        $response = $event->getResponse();

        if (!empty($user)) {

            $userId = $user->getId();


            if ($this->memcached->validateId($userId)) {

                $this->memcached->destroyEspecified($userId);
            }

            if (!$user->getInformacoes()->getEdicoesAtualizadas()->getStatus()) {
                if ($this->memcached->validateId($user->getId() . '_atualizacao')) {
                    $this->memcached->destroyEspecified($user->getId() . '_atualizacao');
                }
            }
        }

        $response = new RedirectResponse(
            $this->urlGenerator->generate('home'),
            RedirectResponse::HTTP_SEE_OTHER
        );

        $cookies = $request->cookies->all();

        foreach ($cookies as $name => $value) {
            $response->headers->setCookie(
                new Cookie($name, '', time() - 3600)
            );
        }

        $event->setResponse($response);
    }
}
