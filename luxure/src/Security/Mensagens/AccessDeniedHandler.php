<?php

declare(strict_types=1);
namespace App\Security\Mensagens;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private Security $security
    ) {
        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }
    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        $user = $this->security->getUser();
        if ($user) {
            $roles = $user->getRoles();
            
            if (in_array('ROLE_USER_N1', $roles, true)) {
                return new RedirectResponse($this->urlGenerator->generate('finalize'));
            } elseif (in_array('ROLE_USER_N2', $roles, true)) {
                return new RedirectResponse($this->urlGenerator->generate('dashboard'));
            }
        }
        
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
    
}