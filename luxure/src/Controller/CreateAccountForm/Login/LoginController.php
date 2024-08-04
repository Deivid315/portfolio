<?php

declare(strict_types=1);

namespace App\Controller\CreateAccountForm\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginController extends AbstractController
{

    public function login(Request $request): Response
    {

        // if ($security->isGranted('IS_AUTHENTICATED')) {
        //     return new RedirectResponse('/user/painel');
        // }
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }       
        
        return $this->render('publico/conta/login/login.html.twig', [
            'email' => "deividaraujo40@gmail.com",
            'senha' => "deividaraujo40@gmail.com"
        ]);
    }

    public function admin(): Response
    {
        return $this->render('publico/conta/login/admin.html.twig');
    }
}
