<?php

declare(strict_types=1);

namespace App\Controller\Logado;

use App\Form\EditarPerfil\EditPerfilForm;
use App\Service\Edicao\EditarConta\EditarConta;
use App\Service\Edicao\ManipuladoresMensagem\EnvioExcecao;
use Exception;
use GuzzleHttp\Client;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class DashboardController extends AbstractController
{
    public function __construct(
        private MemcachedSessionHandler $memcached,
        private TokenStorageInterface $tokenstorage,
        private EditarConta $editar_conta,
        private RequestStack $requestStack,
        private EnvioExcecao $envioExcecao
    ) {
    }

    public function painel(UserInterface $user, Request $request, TokenStorageInterface $token): Response
    {
        var_dump(count($user->getConteudosDaConta()->getArquivosPublicos()['fotosevideos']));
        var_dump($user->getConteudosDaConta()->getArquivosPrivados() !== null ? count($user->getConteudosDaConta()->getArquivosPrivados()['fotosevideos']) : null);

        var_dump($user->getInformacoes()->getEdicoesAtualizadas());
        //var_dump($user->getConteudosDaConta()->getArquivosPublicos());

        //var_dump($user->getInformacoes()->getEdicoesAtualizadas());
        $pp = 'getArquivosPublicos';

        if (!empty($user->getConteudosDaConta()->getArquivosPrivados())) {
            $pp = 'getArquivosPrivados';
        }

        $acesso_pp = $user->getConteudosDaConta()->$pp();

        $s_atual = $user->getId();

        if ($request->getSession()->has('primeiro')) {

            if (!$this->memcached->validateId($s_atual)) {

                $this->memcached->write($s_atual, serialize([$request->cookies->all()]));
            } else {

                $user_antigo = unserialize($this->memcached->read($s_atual));

                $this->envioExcecao->setWebhook(

                    $user->getInformacoes()->getEdicoesAtualizadas()->getIdJwt(),
                    'Você fez login em outro dispositivo. Continue sua sessão por lá.'
                );

                $this->memcached->destroyEspecified($user_antigo[0]['PHPSESSID']);

                $this->memcached->write($s_atual, serialize([$request->cookies->all()]));
            }
            $request->getSession()->remove('primeiro');
        }

        $mm = $user->getConteudosDaConta()->getNotificacoes();
        $ultimos_cinco = array_slice($mm, -5, 5);
        var_dump($ultimos_cinco);

        $alcunha = $user->getAlcunha();
        $fotoevideo = $acesso_pp['fotosevideos'];


        if (count($fotoevideo) > 11) {
            try {
                throw new Exception('a conta do usuário tem mais de 11 imagens,
                portanto ela ficará bloqueada até ser fetia a exclusão');
            } catch (\Throwable $e) {
                configureScope(function (Scope $scope) use (
                    $e,
                    $user,
                ): void {
                    $scope->setUser(
                        [
                            'nome_completo' => $user->getNomeCompleto(),
                            'telefone' => $user->getCelular(),
                            'email' => $user->getEmail(),
                            'roles' => json_encode($user->getRoles()),
                            'status' => $user->getStatus()
                        ]
                    );

                    $scope->setExtra(
                        'informacao_adicional',
                        'exclua uma foto da conta do usuário'
                    );
                });
                captureException($e);

                $token->setToken(null);
                return new Response('Houve um probl com sua conta, estamos verficando ela nesse momento. 
                Tente novamente mais tarde.', 302);
            }
        }


        $detalhes = $acesso_pp['detalhes'];
        $status = $user->getStatus();
        $email = $user->getEmail();
        $capa = null;

        foreach ($fotoevideo as $key => $value) {

            if (strpos($value, 'foto_de_perfil_da_conta') !== false) {
                $capa = $value;
                unset($fotoevideo[$key]);
            }
        }

        if ($user->getInformacoes()->getEdicoesAtualizadas()->getStatus()) {
            $qtd = $user->getInformacoes()->getEdicoesAtualizadas()->getQtd();
            $perfil = $user->getInformacoes()->getEdicoesAtualizadas()->getCapa();
        }
        $response = $this->render('privado/conta/logado/painel.html.twig', [
            'usercompleto' => $user,
            'user' => $alcunha,
            'fotosevideos' => $fotoevideo,
            'detalhes' => $detalhes,
            'capa' => $capa,
            'status' => $status,
            'qtd_server' => isset($qtd) ? $qtd : null,
            'capa_server' => isset($perfil) ? $perfil : null,
            'base' => $user->getInformacoes()->getEdicoesAtualizadas()->getBase(),
            'id_' => $user->getInformacoes()->getEdicoesAtualizadas()->getIdJwt(),
        ]);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

        return $response;
    }

    public function editar(
        UserInterface $user,
        Request $request,
    ): Response {

        /*
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $header = json_encode($header);
        $header = base64_encode($header);

        $salve_serializado = serialize([
            'email' => $user->getEmail(),
            'sessid' => $request->request->get('PHPSESSID')
        ]);
        //alterar depois o localhost para o dominio
        $payload = [
            'iss' => 'localhost',
            'data' => $salve_serializado,
            'iat' => time()
        ];
        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $_ENV['KEY_JWT'], true);
        $signature = base64_encode($signature);
        $jwt = "$header.$payload.$signature";

        $postData = [
            'sess' => $jwt,
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://localhost:8000/config/user/atualiza');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
*/


        var_dump(count($user->getConteudosDaConta()->getArquivosPublicos()['fotosevideos']));
        var_dump($user->getConteudosDaConta()->getArquivosPrivados() !== null ? count($user->getConteudosDaConta()->getArquivosPrivados()['fotosevideos']) : null);
        var_dump($user->getInformacoes()->getEdicoesAtualizadas()); 
        $pp = 'getArquivosPublicos';

        if (!empty($user->getConteudosDaConta()->getArquivosPrivados())) {
            $pp = 'getArquivosPrivados';
        }

        $acesso_pp = $user->getConteudosDaConta()->$pp();

        $mm = $user->getConteudosDaConta()->getNotificacoes();
        $ultimos_cinco = array_slice($mm, -5, 5);
        var_dump($ultimos_cinco);
        $alcunha = $user->getAlcunha();
        $fotoevideo = $acesso_pp['fotosevideos'];
        $detalhes = $acesso_pp['detalhes'];
        $status = $user->getStatus();
        $capa = null;
        $imagens = 0;
        $videos = 0;
        $email = $user->getEmail();

        foreach ($fotoevideo as $key => $value) {

            if (strpos($value, 'foto_de_perfil_da_conta') !== false) {
                $capa = $value;
                unset($fotoevideo[$key]);
            } else if (strpos($value, ".png") !== false || strpos($value, ".heic") !== false || strpos($value, ".jpg") !== false || strpos($value, ".jpeg") !== false) {
                $imagens++;
            } else if (strpos($value, ".mp4") !== false || strpos($value, ".webm") !== false) {
                $videos++;
            }
        }
        $fotoevideo = array_values($fotoevideo);

        $detalhes = $user->getConteudosDaConta()->getArquivosPublicos()['detalhes'];
        $form = $this->createForm(EditPerfilForm::class, null, [
            'data' => [
                'biografia' => $detalhes['biografia'],
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $retorno = $this->editar_conta->processEdicaoConta($request, $form, $user, $request->cookies->all());

            if ($retorno instanceof UserInterface) {

                $this->addFlash(
                    'retorno',
                    'sucesso'
                );
                return new RedirectResponse('/user/painel/editar-perfil');
            } else {

                $this->addFlash(
                    'retorno',
                    $retorno
                );

                return new RedirectResponse('/user/painel/editar-perfil');
            }
        }

        if ($user->getInformacoes()->getEdicoesAtualizadas()->getStatus()) {
            $qtd = $user->getInformacoes()->getEdicoesAtualizadas()->getQtd();
            $perfil = $user->getInformacoes()->getEdicoesAtualizadas()->getCapa();
        }

        $response = $this->render('privado/conta/logado/editarperfil/editarperfil.html.twig', [
            'user' => $alcunha,
            'fotosevideos' => $fotoevideo,
            'detalhes' => $detalhes,
            'form' => $form->createView(),
            'fetiches_selecionados' => $acesso_pp['detalhes']['fetiches'],
            'detalhes_selecionados' => $acesso_pp['detalhes'],
            'capa' => $capa,
            'imagens' => $imagens,
            'videos' => $videos,
            'status' => $status,
            'qtd_server' => isset($qtd) ? $qtd : null,
            'capa_server' => isset($perfil) ? $perfil : null,
        ]);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

        return $response;
    }
}
