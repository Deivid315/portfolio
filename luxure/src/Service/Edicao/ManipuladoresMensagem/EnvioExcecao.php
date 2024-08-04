<?php

declare(strict_types=1);

namespace App\Service\Edicao\ManipuladoresMensagem;

use App\Repository\Uploads\ArquivosRepository;
use GuzzleHttp\Client;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class EnvioExcecao
{

    public function __construct(
        private ArquivosRepository $arquivosRepository,
        private MemcachedSessionHandler $memcached,
        private MessageBusInterface $bus
    ) {
    }

    public function envioTryCatch(
        UserInterface $userint,
        string $jwt,
        string $alerta = 'Houve um erro em nossos serviços, tente editar sua conta mais tarde',
        bool $primeiro_envio = false
    ): void {
        try {
            $userint->getConteudosDaConta()->setArquivosPrivados([]);
            $this->arquivosRepository->salveAlerta($userint, $alerta);
            if (!$primeiro_envio) {
                $postData = [
                    'erros' => [
                        'alerta' => $alerta,
                    ]
                ];
            } else {
                $postData = [
                    'primeiro_envio' => [
                        'alerta' => $alerta,
                        ]
                ];
            }
            $this->webhook($jwt, $alerta);
            $this->memcached->write($userint->getId() . '_atualizacao', serialize($postData));
        } catch (\Throwable $e) {
            configureScope(function (Scope $scope) use (
                $e,
                $userint,
            ): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );

                $scope->setExtra(
                    'informacoes_adicionais',
                    'Foi tentando no manipulador de mensagens atualizar o perfil do usuário
                    porém houve um erro, em seguida foi tentado reverter a alteração no banco
                     de dados, atualizar a sessão atual e enviar um alerta ao usuário sobre o erro,
                     mas houve algum erro desconhecido, provavelmente ligado ao memcached'
                );
            });
            captureException($e);
            $this->webhook($jwt);
        }
    }

    private function webhook(string $jwt, string $alerta = 'houve um erro em nossos serviços, tente editar sua conta mais tarde'): void
    {
        try {
            $client = new Client();
            $client->post('http://localhost:3000/emit', [
                'json' => [
                    'alerta' => $alerta,
                    'jwt' =>  $jwt
                ],
                'timeout' => 15,
            ]);
        } catch (\Throwable $e) {
        }
    }

    public function setWebhook(string $jwt, string $alerta)
    {
        $this->webhook($jwt, $alerta);
    }
}
