<?php

declare(strict_types=1);

namespace App\Controller\Logado\Configuracoes;

use App\Form\Configuracoes\AlterarAlcunhaForm;
use App\Form\Configuracoes\AlterarDataNascimentoForm;
use App\Form\Configuracoes\AlterarEmailForm;
use App\Form\Configuracoes\AlterarSenhaForm;
use App\Form\Configuracoes\AlterarTelefoneForm;
use App\Form\Configuracoes\AlterarUsernameForm;
use App\Form\Configuracoes\DeletarContaForm;
use App\Security\AlterarDados\AlteracoesNaConta;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;

class ConfiguracoesController extends AbstractController
{
    public function __construct(
        private AlteracoesNaConta $alteracoesNaConta,
        private DocumentManager $dm
    ) {
    }

    public function config(Request $request, UserInterface $user, TokenStorageInterface $token): Response
    {

        var_dump($user->getInformacoes()->getAlteracoes());
        var_dump($user->getNascimento());
        var_dump($user->getCelular());
        var_dump($user->getStatus());
        var_dump($user->getUsername());

        $form_senha = $this->createForm(AlterarSenhaForm::class);
        $form_senha->handleRequest($request);

        $form_email = $this->createForm(AlterarEmailForm::class);
        $form_email->handleRequest($request);

        $form_username = $this->createForm(AlterarUsernameForm::class);
        $form_username->handleRequest($request);

        $form_alcunha = $this->createForm(AlterarAlcunhaForm::class);
        $form_alcunha->handleRequest($request);

        $form_telefone = $this->createForm(AlterarTelefoneForm::class);
        $form_telefone->handleRequest($request);

        $form_nascimento = $this->createForm(AlterarDataNascimentoForm::class);
        $form_nascimento->handleRequest($request);

        $form_deletar = $this->createForm(DeletarContaForm::class);
        $form_deletar->handleRequest($request);

        if ($form_email->isSubmitted() && $form_email->isValid()) {

            $this->alteracoesNaConta->alterarEmail($user, $form_email, $token);
        }
        if ($form_username->isSubmitted() && $form_username->isValid()) {

            $this->alteracoesNaConta->alterarUsername($user, $form_username);
        }

        if ($form_senha->isSubmitted() && $form_senha->isValid()) {
            $this->alteracoesNaConta->alterarSenha($user, $form_senha);
        }

        if ($form_alcunha->isSubmitted() && $form_alcunha->isValid()) {

            $this->alteracoesNaConta->alterarDadoEspecifico($user, $form_alcunha, 'alcunha');
        }

        if ($form_telefone->isSubmitted() && $form_telefone->isValid()) {

            $this->alteracoesNaConta->alterarDadoEspecifico($user, $form_telefone, 'celular');
        }

        if ($form_nascimento->isSubmitted() && $form_nascimento->isValid()) {

            $this->alteracoesNaConta->alterarDadoEspecifico($user, $form_nascimento, 'nascimento');
        }

        $mensagem = $request->request->get('mensagem');

        if ($mensagem === "deletar_todas_mensagens_{$user->getEmail()}") {
            $this->alteracoesNaConta->apagarNotificacoes($user);
        }

        if ($request->request->has('status_da_conta')) {
            $status = $request->request->get('status_da_conta');
            if ($status === "ocultar_conta_{$user->getEmail()}") {
                $submittedToken = $request->request->get('token_ocultar');
                if ($this->isCsrfTokenValid('ocultar-item', $submittedToken)) {
                    $this->alteracoesNaConta->offOnConta($user, 'OFFLINE');
                }
            } else if ($status === "mostrar_conta_{$user->getEmail()}") {
                $submittedToken = $request->request->get('token_mostrar');
                if ($this->isCsrfTokenValid('mostrar-item', $submittedToken)) {
                    $this->alteracoesNaConta->offOnConta($user, 'ONLINE');
                }
            }
        }

        if ($form_deletar->isSubmitted() && $form_deletar->isValid()) {
            $this->alteracoesNaConta->deletarConta($form_deletar, $user, $token);
        }

        $response = $this->render('privado/conta/logado/alterar_dados/alteracoes.html.twig', [
            'formulario_senha' => $form_senha,
            'formulario_email' => $form_email,
            'formulario_username' => $form_username,
            'formulario_alcunha' => $form_alcunha,
            'formulario_telefone' => $form_telefone,
            'formulario_nascimento' => $form_nascimento,
            'formulario_deletar' => $form_deletar,
            'user' => $user
        ]);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

        return $response;
    }
}
