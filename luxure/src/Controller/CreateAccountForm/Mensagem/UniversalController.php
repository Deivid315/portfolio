<?php

declare(strict_types=1);

namespace App\Controller\CreateAccountForm\Mensagem;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UniversalController extends AbstractController
{
    public function universal(Request $request, string $value): Response
    {
        $flash = $request->getSession()->getFlashBag();
        if ($flash->has('criacaodeconta')) {
            $flash->clear('criacaodeconta');
            return $this->render('/publico/conta/mensagem/mensagem.html.twig', [
                'texto' => 'Sua conta foi criada com sucesso. Acesse seu email e confirme o link enviado para poder acessar o site.'
            ]);
        }
        if ($flash->has('pagina_universal')) {
            $flash->clear('pagina_universal');
            return $this->render('/publico/conta/mensagem/mensagem.html.twig', [
                'texto' => $value
            ]);
        }
        return new RedirectResponse($this->generateUrl('home'));
    }
}
