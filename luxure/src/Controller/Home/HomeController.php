<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Form\BuscaHome\BuscaForm;
use App\Form\BuscaHome\TodosForm;
use App\Repository\BuscasPublicas\BuscasRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class HomeController extends AbstractController
{
    public function __construct(
        private BuscasRepository $buscasRepository,
        private DocumentManager $dm,
        private CsrfTokenManagerInterface $csrf
    ) {
    }

    public function home(Request $request): Response
    {

        try {

            $data = json_decode($request->getContent(), true);

            if (isset($data['coords']) && is_array($data['coords'])) {

                try {

                    $local = $this->buscasRepository->capturarLoc($data['coords']);
                    $local['select'] = $local['selecionado'] ?? null;
                    
                    if (!isset($local['msg'][530])) {

                        if (isset($local['msg'][200]) || isset($local['msg'][10])) {

                            $result = $this->processarPerfis($local);
                            $local['perfis'] = $result['perfis'];
                            $local['selecionado'] = $result['selecionado'];
                        }
                    }

                    return new JsonResponse(['data' => $local]);
                } catch (\Throwable $d) {
                    configureScope(function (Scope $scope) use ($d) {
                        $scope->setExtra('informcacao_adicional', 'Houve um problema ao procurar $data[coords]');
                    });
                    captureException($d);

                    return new JsonResponse(['data' => ['msg' => [500 => 'Houve um erro desconhecido. Tente novamente mais tarde.']]]);
                }
            }

            if (
                $request->request->has('estado') &&
                $request->request->has('cidades') &&
                is_string($request->request->get('estado')) &&
                is_array($request->request->all('cidades')) &&
                strlen($request->request->get('estado')) === 2 &&
                count($request->request->all('cidades')) <= 3 &&
                $request->request->has('_csrf_token') &&
                is_string($request->request->get('_csrf_token')) &&
                $this->csrf->isTokenValid(new CsrfToken('authenticate', $request->request->get('_csrf_token')))
            ) {
                try {
                    $buscas_gerais = $this->buscasRepository->buscasGF(false, $request->request->get('estado'), $request->request->all('cidades'));

                    $buscas_gerais['select'] = $buscas_gerais['selecionado'] ?? null;
                    if (isset($buscas_gerais['msg'][200]) || isset($buscas_gerais['msg'][10])) {

                        $result = $this->processarPerfis($buscas_gerais);
                        $buscas_gerais['perfis'] = $result['perfis'];
                        $buscas_gerais['selecionado'] = $result['selecionado'];
                    }

                    return new JsonResponse(['data' => $buscas_gerais]);
                } catch (\Throwable $d) {
                    configureScope(function (Scope $scope) use ($d) {
                        $scope->setExtra('informcacao_adicional', 'Houve um problema ao procurar $estado no $rquest->request');
                    });
                    captureException($d);

                    return new JsonResponse(['data' => ['msg' => [500 => 'Houve um erro desconhecido. Tente novamente mais tarde.']]]);
                }
            }



            $formTodos = $this->createForm(TodosForm::class);
            $formTodos->handleRequest($request);
            $form = $this->createForm(BuscaForm::class);
            $form->handleRequest($request);

            if (($form->isSubmitted() && $form->isValid()) || ($formTodos->isSubmitted() && $formTodos->isValid())) {

                try {

                    $buscas_gerais = $this->buscasRepository->buscasGF($form->isSubmitted() ? $form : $formTodos);

                    $buscas_gerais['select'] = $buscas_gerais['selecionado'] ?? null;
                    if (isset($buscas_gerais['msg'][200]) || isset($buscas_gerais['msg'][10])) {

                        $result = $this->processarPerfis($buscas_gerais);
                        $buscas_gerais['perfis'] = $result['perfis'];
                        $buscas_gerais['selecionado'] = $result['selecionado'];
                    }

                    return new JsonResponse(['data' => $buscas_gerais]);
                } catch (\Throwable $d) {
                    configureScope(function (Scope $scope) use ($d) {
                        $scope->setExtra('informcacao_adicional', 'Houve um problema durante o envio de form_issubmitted e formtodos');
                    });
                    captureException($d);

                    return new JsonResponse(['data' => ['msg' => [500 => 'Houve um erro desconhecido. Tente novamente mais tarde.']]]);
                }
            }

            $response = $this->render('publico/home/home.html.twig', [
                'form' => $form,
                'formtodos' => $formTodos,
            ]);

            // $response->setPublic();
            // $response->setMaxAge(604800);
            // $response->setSharedMaxAge(604800);
            // $response->setEtag(md5(json_encode(isset($busca_top['atualizacao']) ? $busca_top['atualizacao']->getAtual() : 'vazio')));
            // $response->setLastModified(isset($busca_top['atualizacao']) ? $busca_top['atualizacao']->getAtual() : new \DateTime);

            // if ($response->isNotModified($request)) {
            //     return $response;
            // }
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

            return $response;
        } catch (\Throwable $e) {
            configureScope(function (Scope $scope) use ($e) {
                $scope->setExtra('informacao_adicional', 'Houve um erro durante a execucação do
                 controller homecontroller e geração do tamplate home.html.twig');
            });
            captureException($e);

            return $this->render('publico/erro_controllers.html.twig');
        }
    }

    public function usuario(string $username): Response
    {

        // try {
        if (!preg_match('/^(?=.*[a-z])[a-z0-9._-]{4,20}$/', $username)) {
            $this->addFlash('mensagem', 'Esse usuário não existe.');
            return new RedirectResponse("/");
        }
        try {

            $buscaEspecifica = $this->buscasRepository->buscaEspecifica($username);
        } catch (\Throwable $e) {
            configureScope(function (Scope $scope) use ($e) {
                $scope->setExtra('informacao_adicional', 'Houve um erro durante a execução de buscasGF(),
                    provavelmente relacionado ao banco de dados');
            });
            captureException($e);

            $response = $this->render('publico/home/perfil.html.twig', [
                'erro' => true,
            ]);

            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
            return $response;
        }

        if (empty($buscaEspecifica)) {
            $this->addFlash('mensagem', 'Esse usuário não existe.');
            return new RedirectResponse("/");
        }

        $fotosev = $buscaEspecifica->getConteudosDaConta()->getArquivosPublicos();
        $capa = null;

        foreach ($fotosev['fotosevideos'] as $key => $cap) {

            if (strpos($cap, 'foto_de_perfil_da_conta') !== false) {
                $capa = $cap;
                unset($fotosev['fotosevideos'][$key]);
                $buscaEspecifica->getConteudosDaConta()->setArquivosPublicos([
                    'fotosevideos' => array_values($fotosev['fotosevideos']),
                    'detalhes' => $buscaEspecifica->getConteudosDaConta()->getArquivosPublicos()['detalhes']

                ]);

                $fotosev = $buscaEspecifica->getConteudosDaConta()->getArquivosPublicos();
            }
        }

        $perfil = [
            "atendimento" => $buscaEspecifica->getConteudosDaConta()->getAtuacao(),
            "arquivos" => $fotosev,
            "alcunha" => $buscaEspecifica->getAlcunha(),
            "nascimento" => $buscaEspecifica->getNascimento(),
            "capa" => $capa,
            "celular" => $buscaEspecifica->getCelular()
        ];

        $response = $this->render('publico/home/perfil.html.twig', [
            'perfil' => $perfil
        ]);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

        return $response;
        // } catch (\Throwable $e) {
        //     configureScope(function (Scope $scope) use ($e) {
        //         $scope->setExtra('informacao_adicional', 'Houve um erro durante a execucação do
        //          controller homecontroller e geração do tamplate perfil.html.twig');
        //     });
        //     captureException($e);

        //     return $this->render('publico/erro_controllers.html.twig');
        // }
    }

    private function processarPerfis(array $buscas_gerais): array
    {

        $sel = [];
        $sel_existe = $buscas_gerais['selecionado'];

        foreach ($buscas_gerais['perfis'] as $value) {

            $fotosev = $value->getConteudosDaConta()->getArquivosPublicos();
            $capa = null;
            foreach ($fotosev['fotosevideos'] as $key => $cap) {

                if (strpos($cap, 'foto_de_perfil_da_conta') !== false) {
                    $capa = $cap;
                }
            }

            $val[] = [
                "detalhes" => $value->getConteudosDaConta()->getArquivosPublicos()['detalhes'],
                "alcunha" => $value->getAlcunha(),
                "nascimento" => $value->getNascimento(),
                "capa" => $capa,
                "username" => $value->getUsername(),
            ];

            if ($sel_existe) {
                if ($value->getSelecionado()) {
                    $sel[] = [
                        "detalhes" => $value->getConteudosDaConta()->getArquivosPublicos()['detalhes'],
                        "alcunha" => $value->getAlcunha(),
                        "nascimento" => $value->getNascimento(),
                        "capa" => $capa,
                        "username" => $value->getUsername(),
                        "selecionado" => $value->getSelecionado()
                    ];
                }
            }
        }
        $buscas_gerais['perfis'] = $val;
        $buscas_gerais['selecionado'] = is_null($sel_existe) ? null : ($sel_existe ? $sel : false);

        return $buscas_gerais;
    }
}
