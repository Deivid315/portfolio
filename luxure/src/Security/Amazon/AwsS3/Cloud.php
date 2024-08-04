<?php

declare(strict_types=1);

namespace App\Security\Amazon\AwsS3;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use GuzzleHttp\Client;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Sentry\State\Scope;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

class Cloud
{

    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public string $msg = 'Pedimos desculpas pelo transtorno pois houve um 
    erro em nossos serviços. Nossa equipe de desenvolvedores já está 
    trabalhando para solucionar isso, portanto, por enquanto não é possível 
    de fazer upload de nenhum arquivos, tente novamente mais tarde.';

    public function aws(array $arrayDeFotos, UserInterface $userint): array|false
    {
        try {
            $id_user = base64_encode(hash('SHA256', $userint->getId(), true));
            $id_user = str_replace(['+', '/', '='], ['-', '_', ''], $id_user);
            var_dump($id_user);

            $s3 = new S3Client([
                'version' => 'latest',
                'region'  => 'sa-east-1'
            ]);

            $referer = 'http://localhost:8000/user/';

            /**
             * O arquivo que tem a chave 'validacao' se refere a foto obrigatório para validar
             * que a pessoa é a mesma das demais fotos, como ela tem que ser salva num lugar
             * diferente da pasta pública ela será  
             * nomeada diferente para que seja salva na pasta privada na pasta do usuário na s3
             * enquanto as outras serão nomeadas para a pasta pública
             */
            $objects = [];

            /**
             * essa função será usada tanto pelo EditarConta quando pelo FotosVideos, ou seja, uma
             * classe edita a conta do usuário enquanto a outra envia os primeiros arquivos durante
             * a finalização do cadastro do usuário na plataforma, logo após confirmar o email.
             * 
             * A foto de validação será enviada somente uma vez, por isso coloquei que caso
             * ela não exista então terá o valor de null
             * 
             * Como na edição de conta o usuário pode não querer editar a foto de perfil e sim
             * as demais, então fiz o mesmo com a validação, assim quando o usuário
             * for alterar a foto de perfil ela existirá e tudo correrá bem, caso ela não exista
             * então o código não criará um caminho pra ela e não buscará algo que não existe já
             * que ela é nula
             */
            $foto_valid = $arrayDeFotos['validacao'] ?? null;
            if (!empty($foto_valid)) {
                $nome_foto_valid =
                    'users/' .
                    $id_user .
                    '/privado/foto_de_validacao_da_conta.' .
                    Uuid::uuid4()->toString() . hash('SHA1', $userint->getId()) .
                    strtolower($foto_valid->getClientOriginalExtension());

                $frase_modificada_validacao = str_replace('@', '_', $nome_foto_valid);
                $seguro = [
                    'Key' => $frase_modificada_validacao,
                    'SourceFile' => $foto_valid->getPathname(),
                    'Metadata' => [
                        'Referer' => $referer
                    ]
                ];
                $objects[] = $seguro;
            }
            //echo 'os arquivos que foram enviados pelo formulario';
            //var_dump($arrayDeFotos);
            //echo 'array de arquivos para salvar na s3 (antes da capa)';
            //var_dump($objects);
            $foto_capa = $arrayDeFotos['capa'] ?? null;
            if (!empty($foto_capa)) {

                $nome_capa = 'users/' .
                    $id_user .
                    '/publico/' .
                    uniqid('foto_de_perfil_da_conta_', true) .
                    Uuid::uuid4()->toString() .
                    rand(100000000, 999999999) . '.' .
                    strtolower($foto_capa->getClientOriginalExtension());


                $frase_modificada_capa = str_replace('@', '_', $nome_capa);
                $capa = [
                    'Key' => $frase_modificada_capa,
                    'SourceFile' => $foto_capa->getPathname(),
                    'Metadata' => [
                        'Referer' => $referer
                    ]
                ];
                $objects[] = $capa;
            }
            
            foreach ($arrayDeFotos as $foto) {
                if ($foto !== $foto_valid && $foto !== $foto_capa) {
                    $nome = 'users/' .
                        $id_user .
                        '/publico/' .
                        uniqid() .
                        Uuid::uuid4()->toString() .
                        '.' . strtolower($foto->getClientOriginalExtension());

                    $frase_modificada = str_replace('@', '_', $nome);

                    $metadata = [
                        'Referer' => $referer
                    ];

                    $objects[] = [
                        'Key' => $frase_modificada,
                        'SourceFile' => $foto->getPathname(),
                        'Metadata' => $metadata
                    ];
                }
            }
            $urls = [];
            foreach ($objects as $object) {
                $result = $s3->putObject([
                    'Bucket' => 'luxureselect',
                    'Key' => $object['Key'],
                    'SourceFile' => $object['SourceFile'],
                    'Metadata' => $object['Metadata']
                ]);

                $objectUrl = $result['ObjectURL'];
                $urls[] = preg_replace('#https://luxureselect\.s3\.sa-east-1\.amazonaws\.com/#', 'https://d36z9a84v3lnn7.cloudfront.net/', $objectUrl);
            }
            //echo 'urls retornadas após o salvamento';
            //var_dump($urls);
            return $urls;
        } catch (S3Exception $e) {

            configureScope(function (Scope $scope) use ($e, $userint): void {
                $scope->setUser([
                    'nome_completo' => $userint->getNomeCompleto(),
                    'telefone' => $userint->getCelular(),
                    'email' => $userint->getEmail()
                ]);
                $scope->setExtra('informacoes_adicionais', 'Não foi possível enviar as fotos e/ou vídeos 
                para a aws s3');
            });
            captureException($e);
            return false;
        } catch (AwsException $m) {
            configureScope(function (Scope $scope) use ($m, $userint): void {
                $scope->setUser([
                    'nome_completo' => $userint->getNomeCompleto(),
                    'telefone' => $userint->getCelular(),
                    'email' => $userint->getEmail()
                ]);
                $scope->setExtra('informacoes_adicionais', 'Não foi possível se conectar a aws
                 para enviar as fotos e vídeos pro s3');
            });
            captureException($m);
            return false;
        } catch (\Throwable $c) {
            configureScope(function (Scope $scope) use ($c, $userint): void {
                $scope->setUser([
                    'nome_completo' => $userint->getNomeCompleto(),
                    'telefone' => $userint->getCelular(),
                    'email' => $userint->getEmail()
                ]);
                $scope->setExtra('informacoes_adicionais', 'Houve alguma exceção que não se
                enquadra na exceção de awsexception ou s3exception');
            });
            captureException($c);
            return false;
        }
    }


    public function deleteAws(array $objectName, UserInterface $userint): bool
    {

        try {
            $s3 = new S3Client([
                'version' => 'latest',
                'region'  => 'sa-east-1'
            ]);

            $objects = [];
            foreach ($objectName as $nome) {
                $objects[] = [
                    'Key' => preg_replace('#https://d36z9a84v3lnn7\.cloudfront\.net/#', '', $nome),
                ];
            }

            /**
             * pensei em usar um deletobjectassync mas não é vantajoso pois o código só deve prosseguir
             * depois que tudo for deletado
             */
            if (count($objects) > 1) {
                $s3->deleteObjects([
                    'Bucket' => 'luxureselect',
                    'Delete' => [
                        'Objects' => $objects,
                    ],
                ]);
                return true;
            } else {
                $s3->deleteObject([
                    'Bucket' => 'luxureselect',
                    'Key' => $objects[0]['Key'],
                ]);
                return true;
            }
        } catch (S3Exception $e) {
            configureScope(function (Scope $scope) use ($e, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Não foi possível fazer
                a exlusão das fotos e vídeos da s3');
            });
            captureException($e);

            return false;
        } catch (AwsException $m) {
            configureScope(function (Scope $scope) use ($m, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Não foi possível se conectar a aws quando foi
                 tentado excluir os arquivos da s3');
            });
            captureException($m);
            return false;
        } catch (\Throwable $c) {
            configureScope(function (Scope $scope) use ($c, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Houve alguma exceção que não se enquadra na exceção 
                da aws ou s3 quando foi tentado excluir os arquivos da s3');
            });
            captureException($c);
            return false;
        }
    }

    public function deletarContaAws(UserInterface $userint): bool
    {
        $id_user = base64_encode(hash('SHA256', $userint->getId(), true));
        $id_user = str_replace(['+', '/', '='], ['-', '_', ''], $id_user);

        try {
            $s3 = new S3Client([
                'version' => 'latest',
                'region'  => 'sa-east-1'
            ]);
            $folderKey = "users/{$id_user}/";

            $s3->deleteMatchingObjects('luxureselect', $folderKey);

            return true;
        } catch (S3Exception $e) {
            configureScope(function (Scope $scope) use ($e, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'usuário tentou deletar a conta mas não foi possível fazer
                a exlusão da pasta da s3');
            });
            captureException($e);

            return false;
        } catch (AwsException $m) {
            configureScope(function (Scope $scope) use ($m, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Não foi possível se conectar a aws quando foi
                 tentado excluir a pasta do usuário da s3');
            });
            captureException($m);
            return false;
        } catch (\Throwable $c) {
            configureScope(function (Scope $scope) use ($c, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Houve alguma exceção que não se enquadra na exceção 
                da aws ou s3 quando foi tentado excluir a pasta do usuário da s3');
            });
            captureException($c);
            return false;
        }
    }

    /**
     * essa função tinha o objetivo de alterar o nome da pasta do usuário para que os arquivos
     * não pudessem ser acessados caso alguém copiasse o link de um imagem antes do determinado
     * usuário suspender a conta, por consequência ele conseguiria acessar a imagem da conta
     * mesmo com ela estando suspensa, porém configurei no lambda@edge para que os arquivos
     * possa ser acessados somente com o referer do dominio, ou seja, para que alguém possa
     * acessar uma imagem de uma conta suspensa além da pessoa ter copiado o link da imagem
     * antes da conta ser suspensa ainda teria que enviar um curl colocando o meu dominio
     * como referer, somente assim para visualizar a imagem, mas tendo o em vista o número
     * de pessoa que conseguem fazer isso e a sobrecarga que o sistema teria em renomear
     * arquivos, atualizar banco de dados, lidar com exceções e tudo mais, então seguirei
     * desabilitando essa função
     */
    public function suspenderContaAws(UserInterface $userint, string $status, string $variavel): bool
    {
        $id_user = base64_encode(hash('SHA256', $userint->getId(), true));
        $id_user = str_replace(['+', '/', '='], ['-', '_', ''], $id_user);

        // try {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'sa-east-1'
        ]);

        $oldPrefix = "users/{$id_user}";
        if ($status === 'OFFLINE') {
            $userint->getInformacoes()->setChaveOffline($variavel);
            $newPrefix = "users/{$id_user}{$variavel}/";

            $result = $s3Client->listObjectsV2([
                'Bucket' => 'luxureselect',
                'Prefix' => $oldPrefix . '/',
            ]);

            if (isset($result['Contents'])) {
                foreach ($result['Contents'] as $object) {
                    $oldKey = $object['Key'];
                    $newKey = str_replace($oldPrefix . '/', $newPrefix, $oldKey);

                    $s3Client->copyObject([
                        'Bucket' => 'luxureselect',
                        'CopySource' => "luxureselect/{$oldKey}",
                        'Key' => $newKey,
                    ]);

                    $s3Client->deleteObject([
                        'Bucket' => 'luxureselect',
                        'Key' => $oldKey,
                    ]);
                }
            }
            $this->alterarNomesOnline($userint, $id_user);
            
        } else if ($status === 'ONLINE') {
            $userint->getInformacoes()->setChaveOffline(null);
            $oldPrefix = "users/{$id_user}";
            $newPrefix = "{$oldPrefix}/"; // Novo prefixo para os usuários não suspensos
            $regexPattern = '/^users\/' . preg_quote($id_user, '/') . '.*$/';

            $continuationToken = null;
            do {
                $result = $s3Client->listObjectsV2([
                    'Bucket' => 'luxureselect',
                    'Prefix' => $oldPrefix,
                    'ContinuationToken' => $continuationToken,
                ]);

                if (isset($result['Contents'])) {
                    foreach ($result['Contents'] as $object) {
                        $oldKey = $object['Key'];

                        if (preg_match($regexPattern, $oldKey)) {
                            $newKey = str_replace($oldPrefix, $newPrefix, $oldKey);

                            $newKey = preg_replace('#' . $id_user . $variavel . '#', $id_user, $oldKey);

                            $s3Client->copyObject([
                                'Bucket' => 'luxureselect',
                                'CopySource' => "luxureselect/{$oldKey}",
                                'Key' => $newKey,
                            ]);

                            $s3Client->deleteObject([
                                'Bucket' => 'luxureselect',
                                'Key' => $oldKey,
                            ]);
                        }
                    }
                }
                $continuationToken = $result['NextContinuationToken'] ?? null;
            } while ($continuationToken);
            $this->desfazerNomesOffline($userint, $variavel);
        }

        return true;
        try {
        } catch (S3Exception $e) {
            configureScope(function (Scope $scope) use ($e, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'usuário tentou deletar a conta mas não foi possível fazer
                a exlusão da pasta da s3');
            });
            captureException($e);

            return false;
        } catch (AwsException $m) {
            configureScope(function (Scope $scope) use ($m, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Não foi possível se conectar a aws quando foi
                 tentado excluir a pasta do usuário da s3');
            });
            captureException($m);
            return false;
        } catch (\Throwable $c) {
            configureScope(function (Scope $scope) use ($c, $userint): void {
                $scope->setUser(
                    [
                        'nome_completo' => $userint->getNomeCompleto(),
                        'telefone' => $userint->getCelular(),
                        'email' => $userint->getEmail(),
                        'roles' => json_encode($userint->getRoles()),
                        'status' => $userint->getStatus()
                    ]
                );
                $scope->setExtra('informacoes_adicionais', 'Houve alguma exceção que não se enquadra na exceção 
                da aws ou s3 quando foi tentado excluir a pasta do usuário da s3');
            });
            captureException($c);
            return false;
        }
    }

    /**
     * essa função faz parte do grupo de funções que não será utilizado no momento 
     * por questões de sobrecarregamento no sistema devido a motivos que não fazem
     * sentido me preocupar no momento
     * @see suspenderContaAws() e alterarNomesOnline()
     */
    private function desfazerNomesOffline(UserInterface $user, string $variavel): void
    {
        $fotosevideos = $user->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'];
        $arquivos_novos = [];
        foreach ($fotosevideos as $key => $value) {
            $caminho_n = preg_replace("#{$variavel}#", "", $value);
            $arquivos_novos[$key] = $caminho_n;
        }
        $user->getConteudosDaConta()->setArquivosPublicos([
            'fotosevideos' => $arquivos_novos,
            'detalhes' => $user->getConteudosDaConta()->getArquivosPublicos()['detalhes']
        ]);
    }

    /**
     * essa função faz parte do grupo de funções que não será utilizado no momento 
     * por questões de sobrecarregamento no sistema devido a motivos que não fazem
     * sentido me preocupar no momento
     * @see suspenderContaAws() e desfazerNomesOffline()
     */
    private function alterarNomesOnline(UserInterface $user, string $id_user): void
    {
        $fotosevideos = $user->getConteudosDaConta()->getArquivosPublicos()['fotosevideos'];
        $arquivos_novos = [];
        foreach ($fotosevideos as $key => $value) {
            $caminho_n = preg_replace("#{$id_user}#", "{$id_user}{$user->getInformacoes()->getChaveOffline()}", $value);
            $arquivos_novos[$key] = $caminho_n;
        }
        $user->getConteudosDaConta()->setArquivosPublicos([
            'fotosevideos' => $arquivos_novos,
            'detalhes' => $user->getConteudosDaConta()->getArquivosPublicos()['detalhes']
        ]);
    }
}