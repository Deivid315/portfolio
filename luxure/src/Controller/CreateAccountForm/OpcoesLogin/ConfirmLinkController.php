<?php

declare(strict_types=1);

namespace App\Controller\CreateAccountForm\OpcoesLogin;

use App\Repository\Uploads\ArquivosRepository;
use App\Service\Token\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ConfirmLinkController extends AbstractController
{

    public function __construct(
        private ArquivosRepository $arquivosRepository,
        private TokenGenerator $tokenGenerator
        )
    {}

    public function confirmLink($value): Response
    {
        $this->addFlash('pagina_universal', true);
        if($this->tokenGenerator->confirmToken($value)){
            $user = $this->arquivosRepository->link($value);

            if($user){
                $url = $this->generateUrl('pag_universal', [
                    'value' => 'Sua conta foi confirmada com sucesso!'
                ]);
                return new RedirectResponse($url);
            }else{
                $url = $this->generateUrl('pag_universal', [
                    'value' => 'O link para confirmação do email está expirado!'
                ]);
                return new RedirectResponse($url);
            }

        }else{
            $url = $this->generateUrl('pag_universal', [
                'value' => 'O link para confirmação do email está expirado!'
            ]);
            return new RedirectResponse($url);
        }
         
    }
}
