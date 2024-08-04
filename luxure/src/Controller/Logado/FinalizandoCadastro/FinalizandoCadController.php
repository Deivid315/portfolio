<?php

declare(strict_types=1);

namespace App\Controller\Logado\FinalizandoCadastro;

use App\Form\FimCadastro\FinalizandoCadastroForm;
use App\Repository\Uploads\ArquivosRepository;
use App\Service\Edicao\FotosVideos;
use App\Service\Edicao\ManipuladoresMensagem\EnvioExcecao;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\VarDumper\VarDumper;

class FinalizandoCadController extends AbstractController
{
    public function __construct(
        private MemcachedSessionHandler $memcached,
        private EnvioExcecao $envioExcecao,
    ) {
    }

    public function finalizandoInfo(Request $request, UserInterface $user, FotosVideos $fotosvideos): Response
    {

        $alcunha = $user->getAlcunha();

        $form = $this->createForm(FinalizandoCadastroForm::class);
        $form->handleRequest($request);
        $envio = $user->getInformacoes()->getEdicoesAtualizadas()->getPrimeiroEnvio();
        var_dump($envio);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                /**
                 * apóso o envio do formulário as informações serão enviadas para o método envioMongoeAws
                 * lá é onde as fotos e vídeo serão enviados para a aws s3 e em seguida salvos no mongodb atlas.
                 * Repare que está sendo passada para a função o $request que contém os detalhes do $form
                 * bem como $user que contém os detalhes do usuário logado pois ele é necessário para
                 * que a sessão do usuário seja atualizada
                 */
                $retorno = $fotosvideos->envioMongoeAws($request, $form, $user);
                if ($retorno === true) {
                    return new RedirectResponse($this->generateUrl('finalize'));
                } else {

                    return $this->render('privado/conta/logado/finalizandocadastro/finalizandoInfo.html.twig', [
                        'user' => $alcunha,
                        'form' => $form,
                        'retorno' => $retorno,
                        'usercompleto' => $user,
                        'base' => $user->getInformacoes()->getEdicoesAtualizadas()->getBase(),
                        'id_' => $user->getInformacoes()->getEdicoesAtualizadas()->getIdJwt(),
                        'envio' => $envio
                    ]);
                }
            }
        }

        return $this->render('privado/conta/logado/finalizandocadastro/finalizandoInfo.html.twig', [
            'user' => $alcunha,
            'form' => $form->createView(),
            'usercompleto' => $user,
            'base' => $user->getInformacoes()->getEdicoesAtualizadas()->getBase(),
            'id_' => $user->getInformacoes()->getEdicoesAtualizadas()->getIdJwt(),
            'envio' => $envio
        ]);
    }
}
