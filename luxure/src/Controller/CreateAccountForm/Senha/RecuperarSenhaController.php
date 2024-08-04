<?php

declare(strict_types=1);

namespace App\Controller\CreateAccountForm\Senha;

use App\Form\AlterarSenha\CampoEmailForm;
use App\Security\TrocarSenha\ValidacaoSenha;
use App\Service\Token\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RecuperarSenhaController extends AbstractController
{

    public function __construct(
        private RateLimiterFactory $trocarsenhaAttemptsLimiter,
        private TokenGenerator $url,
        private ValidacaoSenha $validacao
    ) {
    }

    public function verifique(
        Request $request,
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }     

        $form = $this->createForm(CampoEmailForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $limiter = $this->trocarsenhaAttemptsLimiter->create($request->getClientIp());
            $limit = $limiter->consume(1);
            if (false === $limit->isAccepted()) {
                $this->addFlash(
                    'limite-criacao-de-conta',
                    'Você está trocando de senha rápido demais, por questões de segurança seu acesso foi limitado por determinado tempo!'
                );
                return new RedirectResponse($this->generateUrl('app_login'));
            }

            $email = $form->getData()['email'];
            $enviar_e_trocar = $this->validacao->valida($email);

            $this->addFlash('pagina_universal', true);
            if (isset($enviar_e_trocar['sucesso'])) {

                return new RedirectResponse($this->generateUrl('pag_universal', [
                    'value' => 'O link para alteração de senha foi enviado para sua conta com sucesso!'
                ]));
            } else {

                return new RedirectResponse($this->generateUrl('pag_universal', [
                    'value' => $enviar_e_trocar['erro']
                ]));
            }
        }

        return $this->render('publico/conta/senha/trocar-senha.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
