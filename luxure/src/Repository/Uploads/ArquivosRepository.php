<?php

declare(strict_types=1);

namespace App\Repository\Uploads;

use App\Document\Modificacao\Atualizacao;
use App\Document\Usuario\User;
use App\Security\Amazon\AwsS3\Cloud;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class ArquivosRepository
{

    public string $msgerro = 'Pedimos desculpas pelo transtorno pois houve um 
    erro em nossos serviços. Nossa equipe de desenvolvedores já está 
    trabalhando para solucionar isso, portanto, por enquanto não é possível 
    de fazer upload de nenhum arquivos, tente novamente mais tarde.';

    public function __construct(
        private Cloud $cloud,
        private DocumentManager $dm,
        private UserPasswordHasherInterface $pass,
        private UserPasswordHasherInterface $p,
        private TokenStorageInterface $tokenStorage,
        private RequestStack $requestStack,
        private LoggerInterface $logger
    ) {
    }

    public function uploadInicial(array $arquivos, array $detalhes, UserInterface $user, string $username): object|array
    {
        try {
            $privado = $arquivos[0];
            $output = array_slice($arquivos, 1);
            $upload_final = ['fotosevideos' => $output, 'detalhes' => $detalhes];

            $objeto = $this->dm->createQueryBuilder(User::class)
                ->findAndUpdate()
                ->returnNew()
                ->field('email')->equals($user->getEmail())

                ->field('conteudos.foto_validacao')->set($privado)
                ->field('conteudos.arquivos_publicos')->set($upload_final)
                ->field('roles')->set(['ROLE_USER_N2'])
                ->field('status')->set('ONLINE')
                ->field('username')->set($username)
                ->field('informacoes.edicoes_atualizadas.primeiro_envio')->unsetField()
                ->getQuery()
                ->execute();

                $this->ultimaAtualizacao();

            return $objeto;
        } catch (\Throwable $me) {

            $this->cloud->deleteAws($arquivos, $user);

            $this->catch(
                $me,
                $user,
                'Depois de upload dos arquivos para a aws s3 e o retorno dos links de acesso 
                foi tentado salvar os links no mongodb, porém houve algum erro no mongodb e não foi possível 
                fazer o upload dos links'
            );

            return [
                'error' => true
            ];
        }
    }

    public function link(string $value): bool
    {
        try {
            $qb = $this->dm->createQueryBuilder(User::class)
                ->field('validacao_da_conta.chave')->equals($value)
                ->select('validacao_da_conta', 'status');

            $query = $qb->getQuery();
            $user = $query->getSingleResult();

            if ($user) {
                $criacao = $user->getValidacaoDaConta()->getConfirmacaoDeEmail();
                $atual = new \DateTime();
                $segundos = $atual->getTimestamp() - $criacao->getTimestamp();
                if ($segundos <= 3600) {

                    $user->getValidacaoDaConta()->setConfirmacaoDeEmail($atual);
                    $user->getValidacaoDaConta()->setChave(null);
                    $user->getValidacaoDaConta()->setStatus(true);
                    $user->getValidacaoDaConta()->setExpiracao(null);
                    if ($user->getStatus() === 'PENDENTE_CONF_EMAIL') {
                        $user->setStatus('AGUARDANDO_ENVIO_ARQS');
                    }
                    $this->dm->persist($user);
                    $this->dm->flush();
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Throwable $e) {

            configureScope(function (Scope $scope) use ($e): void {
                $scope->setExtra('informacao_adicional', 'Ocorreu um erro durante a alteração das informações do usuário em relação
                a confirmação do link de ativação da conta');
            });
            captureException($e);
            return false;
        }
    }

    public function salveInicio(UserInterface $user, array $detalhesERemovidos = [], ?bool $primeiro_envio = null): bool
    {
        try {
            if (!empty($detalhesERemovidos)) {

                $query = $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('email')->equals($user->getEmail());

                if ($detalhesERemovidos['cont']) {
                    $detalhes = $user->getConteudosDaConta()->getArquivosPublicos()['detalhes'];
                    $query->field('conteudos.arquivos_publicos.detalhes')->set($detalhes);
                }
                if ($detalhesERemovidos['remov_sep']) {
                    $fotosEVideos = $user->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'];
                    $query->field('conteudos.arquivos_publicos.fotosevideos')->set($fotosEVideos);
                }

                $query->getQuery()->execute();

                $this->ultimaAtualizacao();

                return true;
            } else if ($primeiro_envio !== null) {
                $this->dm->createQueryBuilder(User::class)
                    ->findAndUpdate()
                    ->field('email')->equals($user->getEmail())

                    ->field('informacoes.edicoes_atualizadas.primeiro_envio')->set($primeiro_envio)
                    ->getQuery()
                    ->execute();

                return true;
            } else {
                $this->dm->persist($user);
                $this->dm->flush();

                $this->ultimaAtualizacao();

                return true;
            }
        } catch (\Throwable $e) {
            $this->catch(
                $e,
                $user,
                'Ocorreu um erro ao salvar os dados do usuário
            para então disparar a mensagem ao transport!'
            );
            return false;
        }
    }

    public function salveAlerta(UserInterface $user, string $mensagem = 'Houve um erro em nossos serviços, tente executar a alteração mais tarde.'): void
    {
        try {
            $user->getInformacoes()->getEdicoesAtualizadas()->setQtd(0);
            $user->getInformacoes()->getEdicoesAtualizadas()->setCapa(false);
            $user->getInformacoes()->getEdicoesAtualizadas()->setStatus(false);
            $user->getInformacoes()->getEdicoesAtualizadas()->setPrimeiroEnvio(null);
            $user->getConteudosDaConta()->setNotificacoes($mensagem);
            $this->dm->persist($user);
            $this->dm->flush();
        } catch (\Throwable $me) {
            $this->catch(
                $me,
                $user,
                'Seguinte ordem ocorreu: 1 - Houve um erro durante
            o processo no manipulador de mensagens; 2 - foi solicitado para que campo Info do documento
            tivesse o status de false no mongodb; 3 - houve um erro durante a atualização; solução: terá
            de ser fetia a altereração de forma manual!'
            );
        }
    }

    public function uploadsFotosEVideos(
        ?array $arquivos,
        ?array $detalhes,
        UserInterface $user,
        bool $info = false,
    ): array|UserInterface {

        $arq_atual = $user->getConteudosDaConta()->getArquivosPrivados();

        try {

            $fv = null;

            /**
             * se existir algum array contendo os links dos arquivos
             * então ele é inserido no campo arquivos do documento
             * do usário, caso não então apenas é enviado os arquivos
             * atuais
             */
            if (empty($arquivos)) {
                $fv = ['fotosevideos' => $arq_atual['fotosevideos']];
            } else {
                $fv = ['fotosevideos' => array_values($arquivos)];
            }

            $capa = 0;
            $fotos = 0;
            foreach ($fv['fotosevideos'] as $key => $value) {
                if (strpos($value, 'foto_de_perfil_da_conta') !== false) {
                    $capa++;
                    if ($capa > 1) {
                        unset($fv['fotosevideos'][$key]);
                    }
                } else {
                    $fotos++;
                    if ($fotos > 10) {
                        unset($fv['fotosevideos'][$key]);
                    }
                }
            }

            $conta = count($fv['fotosevideos']);

            $det = $conta ? ['detalhes' => array_merge($arq_atual['detalhes'], $detalhes)] : [];
            $mescle = array_merge($fv, $det);

            $user->getConteudosDaConta()->setArquivosPublicos($mescle);
            $user->getConteudosDaConta()->setArquivosPrivados([]);

            if ($info) {
                $user->getInformacoes()->getEdicoesAtualizadas()->setQtd(0);
                $user->getInformacoes()->getEdicoesAtualizadas()->setCapa(false);
                $user->getInformacoes()->getEdicoesAtualizadas()->setStatus(false);
            }

            $this->dm->persist($user);
            $this->dm->flush();

            $this->ultimaAtualizacao();

            return $user;
        } catch (\Throwable $me) {
            $this->catch(
                $me,
                $user,
                'Durante a atualização das fotos de perfil
                ou dos detalhes no perfil do usuário no mongodb
                houve algum problema relacionado ao mesmo e consequentemente os dados não puderam serem salvos'
            );

            return [
                'error' => true,
                'message' => $this->msgerro
            ];
        }
    }

    private function catch(object $excecao, UserInterface $user, string $informacao): void
    {
        configureScope(function (Scope $scope) use ($excecao, $user, $informacao): void {
            $scope->setUser(
                [
                    'nome_completo' => $user->getNomeCompleto(),
                    'telefone' => $user->getCelular(),
                    'email' => $user->getEmail(),
                    'roles' => json_encode($user->getRoles()),
                    'status' => $user->getStatus()
                ]
            );
            $scope->setExtra('informacao_adicional', $informacao);
        });
        captureException($excecao);
    }

    private function ultimaAtualizacao(): void
    {
        $atualizacao = new Atualizacao();
        $data = new DateTime();
        $atualizacao->setAtual($data);
        
        $this->dm->persist($atualizacao);
        $this->dm->flush();
        $this->dm->clear(Atualizacao::class);
    }
}
