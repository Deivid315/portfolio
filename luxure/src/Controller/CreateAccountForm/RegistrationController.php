<?php

declare(strict_types=1);

namespace App\Controller\CreateAccountForm;

use App\Document\Usuario\User;
use App\Form\Type\CadastroInicialForm;
use App\Security\UserConfidential\Cadastro\Processos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class RegistrationController extends AbstractController
{

    public function __construct(
        private Processos $process,
        private RateLimiterFactory $registrationAttemptsLimiter
    ) {
    }

    public function register(
        Request $request,
    ): Response {

        //verifica se existe um usuário autenticado
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }     

        $user = new User();
        $form = $this->createForm(CadastroInicialForm::class, $user);
        // var_dump($form);exit;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //se crier mais de 5 contas dentro de 24 horas o acesso é bloqueado por 24 horas
            $limiter = $this->registrationAttemptsLimiter->create($request->getClientIp());
            //$limiter->reset();
            $limit = $limiter->consume(1);
            if (false === $limit->isAccepted()) {
                $this->addFlash(
                    'limite-criacao-de-conta',
                    'Você está criando contas rápido demais, por questões de segurança seu acesso foi limitado por determinado tempo!'
                );
                return new RedirectResponse($this->generateUrl('app_register'));
            }

            $resposta = $this->process->check($user);

            if ($resposta === true) {
                $user = new User();
                $form = $this->createForm(CadastroInicialForm::class, $user);

                $this->addFlash(
                    'criacaodeconta',
                    true
                );

                return new RedirectResponse($this->generateUrl('pag_universal', ['value' => 'conta-criada-com-sucesso']));
            } else {
                return $this->render(
                    'publico/conta/form/cadastro.html.twig',
                    [
                        'form' => $form,
                        'alerta' => $resposta['erro'],
                    ]
                );
            }
        }

        return $this->render(
            'publico/conta/form/cadastro.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

}
