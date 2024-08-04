<?php

declare(strict_types=1);

namespace App\Controller\CreateAccountForm\Senha;

use App\Form\AlterarSenha\ConfirmarSenhaForm;
use App\Repository\UserAuthenticate\AuthenticateRepository;
use App\Service\Email\EnviarEmailMailer;
use App\Service\Token\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrocarSenhaController extends AbstractController
{

    public function troque(
        Request $request,
        string $token,
        EnviarEmailMailer $envio,
        TokenGenerator $tokenGenerator,
        AuthenticateRepository $authenticateRepository
    ): Response {

        if (!$tokenGenerator->confirmToken($token)) {
            $this->addFlash('pagina_universal', true);
            $url = $this->generateUrl('pag_universal', [
                'value' => 'O link de senha está expirado'
            ]);
            return new RedirectResponse($url);
        }

        $verificacao = $authenticateRepository->linkSenha($token);
        //var_dump($verificacao);exit;
        if (is_null($verificacao)) {
            $this->addFlash('pagina_universal', true);
            $url = $this->generateUrl('pag_universal', [
                'value' => 'Houve um problema em nossos serviços, tente novamente mais tarde'
            ]);
            return new RedirectResponse($url);
        } else if (!$verificacao) {
            $this->addFlash('pagina_universal', true);
            $url = $this->generateUrl('pag_universal', [
                'value' => 'O link de senha está expirado'
            ]);
            return new RedirectResponse($url);
        }

        $form = $this->createForm(ConfirmarSenhaForm::class, [
            'url' => $token
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('pagina_universal', true);

            $senha = $form->getData()['senha'];
            $codigo = $form->getData()['url'];
            $resultado_validacao = $authenticateRepository->confirmSenha($codigo, $senha);

            if (is_string($resultado_validacao)) {

                $destino = $resultado_validacao;
                $titulo = 'Informativo: Troca de senha realizada';
                $html = '<p>A senha da sua conta acabou de ser alterada!</p>';

                $envio->enviar($destino, $titulo, $html);

                $this->addFlash('trocar_senha_sucesso', 'Sua senha foi alterada 
                com sucesso, faça login para acessar sua conta.');
                $url = $this->generateUrl('app_login');
                return new RedirectResponse($url);
            } else if (!$resultado_validacao) {
                $url = $this->generateUrl('pag_universal', [
                    'value' => 'O link para confirmação do email está expirado!'
                ]);
                return new RedirectResponse($url);
            } else {
                $url = $this->generateUrl('pag_universal', [
                    'value' => 'Houve um problema em nossos serviços, tente novamente mais tarde'
                ]);
                return new RedirectResponse($url);
            }
        }

        return $this->render('publico/conta/senha/form_troca_de_senha.html.twig', [
            'url' => $token,
            'form' => $form->createView()
        ]);
    }
}
