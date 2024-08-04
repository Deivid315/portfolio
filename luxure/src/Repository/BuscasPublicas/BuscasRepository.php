<?php

declare(strict_types=1);

namespace App\Repository\BuscasPublicas;

use App\Document\Modificacao\Atualizacao;
use App\Document\Usuario\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use GuzzleHttp\Client;
use Sentry\State\Scope;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use function Sentry\captureException;
use function Sentry\configureScope;

class BuscasRepository
{
    public function __construct(
        private DocumentManager $dm
    ) {
    }
    // vazio = 101
    // sucesso = 200
    // erro = 500
    // 10 = não foi encontarda com basd nso criterios
    // 9 = insira um filtro de busca

    public function buscasGF(bool|FormInterface $form = false, ?string $estado = null, ?array $cidade = null): ?array
    {
        try {

            $parametros = [];
            $valor_original = [];
            $msg = [];
            $geral = null;

            if ($form instanceof FormInterface && count($form->getData()) > 1) {

                $values = $form->getData();

                list($estado, $cidades) = explode(":", $values['localizacao']);
                $cidades = explode(",", $cidades);

                $qb = $this->dm->createQueryBuilder(User::class);

                $fields = [
                    'idade', 'valor', 'altura', 'peso', 'local',
                    'etnia', 'sexualidade', 'cabelo', 'posicao', 'fetiches'
                ];

                $nulo = 0;

                if (is_int($values['idade']) && $values['idade'] < 18) {
                    return ['msg' => [467 => 'Nosso site foi criado para pessoas maiores de idade! Não existem acompanhantes menores que 18 anos!']];
                } else if (is_int($values['idade']) && $values['idade'] > 100) {
                    return ['msg' => [468 => 'Não existe acompanhante maior que 99 anos, digite uma idade válida!']];
                }

                foreach ($fields as $field) {
                    $valor_original[$field] = $values[$field];

                    if (!empty($values[$field])) {
                        if ($field === 'valor') {
                            list($beforeSlash, $afterSlash) = explode('/', $values[$field]);
                            $qb->field("conteudos.arquivos_publicos.detalhes.$field")->range((int) $beforeSlash, (int) $afterSlash);

                            $values[$field] = 'R$' . (int)$beforeSlash . ',00 a R$ ' . (int)$afterSlash . ',00';
                        } else if ($field === 'peso' || $field === 'altura') {
                            list($beforeSlash, $afterSlash) = explode('/', $values[$field]);
                            $qb->field("conteudos.arquivos_publicos.detalhes.$field")->range((float) $beforeSlash, (float) $afterSlash);

                            $values[$field] = $field === 'peso' ? (int)$beforeSlash . ' kg a ' . (int)$afterSlash . ' kg' : (float)$beforeSlash . ' m a ' . (float)$afterSlash . ' m';
                        } elseif ($field === 'fetiches') {
                            $qb->field("conteudos.arquivos_publicos.detalhes.$field")->all($values[$field]);

                            $values[$field] = implode(', ', $values[$field]);
                        } elseif ($field === 'idade') {
                            $date = new \DateTime();
                            $date->modify("- " . $values[$field] - 1 . " years");
                            $qb->field("nascimento")->lte($date);
                            $values[$field] = $values[$field] . ' anos';
                        }
                        /**
                         * condição para buscar pelo username ou nome de usuário, desabilitei agora mas 
                         * mais pra frente ativar ela, para fazer isso tem que deixar claro que o usuário
                         * poderá user de filtro apenas o texto, ou seja, não será considerado características
                         * como cabelo, sexualidade, etc. Por eu achar que ficaria muita inforamção para ele
                         * então desabilitei ela.
                         */
                            // elseif ($field === 'username') {

                            //     $stringSemEspacosMultiplos = preg_replace('/\s+/', ' ', $values[$field]);

                            //     if (strpos($values[$field], $stringSemEspacosMultiplos) !== false) {
                            //         $qb->text(search: '"' . $values[$field] . '"');
                            //     } else {
                            //         $qb->text(search: $values[$field]);
                            //     }
                            // } 
                        else {

                            $qb->field("conteudos.arquivos_publicos.detalhes.$field")->equals($values[$field]);
                        }
                    } else {
                        $nulo++;
                    }
                    empty($values[$field]) ? null : $parametros[] = "$field: $values[$field]";
                }

                if ($nulo === count($fields)) {
                    return ['msg' => [9 => 'Insira um filtro de busca']];
                }

                $qb->field("conteudos.atuacao.$estado")->in($cidades);

                $qb->select(
                    'conteudos.arquivos_publicos.detalhes.altura',
                    'conteudos.arquivos_publicos.detalhes.peso',
                    'conteudos.arquivos_publicos.detalhes.valor',
                    'conteudos.arquivos_publicos.fotosevideos',
                    'conteudos.atuacao',
                    'alcunha',
                    'nascimento',
                    'username'
                );

                $query = $qb->getQuery();

                if (empty($query->toArray())) {
                    $users = $this->buscasGerais($estado, $cidades);
                    $msg = [10 => "Não foram encontradas acompanhantes de acordo com seus critérios. De uma olhada jararar"];
                } else {
                    $users = $query->toArray();
                }
            } else if ($form instanceof FormInterface) {

                $values = $form->getData();

                list($estado, $cidades) = explode(":", $values['localizacao']);
                $cidades = explode(",", $cidades);

                $users = $this->buscasGerais($estado, $cidades);
                $geral = empty($users) ? false : true;
            } else {
                $users = $this->buscasGerais($estado, $cidade);
                $geral = empty($users) ? false : true;
            }

            if (empty($users)) {
                $geral = is_null($geral) ? null : $geral;
                return ['msg' => [101 => 'Não há perfis nessa localização'], 'selecionado' => $geral];
            }
            
            return [
                'valor_original' => $valor_original,
                'msg' => empty($msg) ? [200 => "sucesso"] : $msg,
                'perfis' => $users,
                'parametros' => !empty($parametros) ? implode(', ', $parametros) : null,
                'selecionado' => $geral

            ];
        } catch (\Throwable $e) {
            configureScope(function (Scope $scope) use ($e) {
                $scope->setExtra('informacao_adicional', 'Houve um erro durante a execução de buscasGF($form->isSubmitted() ? $form : false);,
                    provavelmente relacionado ao banco de dados');
            });
            captureException($e);

            return ['msg' => [500 => 'Houve um erro em nossos serviços. Tente novamente mais tarde.']];
        }
    }

    public function atualizacao(): Atualizacao
    {
        return $this->dm->getRepository(Atualizacao::class)->find('1');
    }

    private function buscasGerais(string $estado, array $cidade): array
    {

        $qb = $this->dm->createQueryBuilder(User::class)
            ->field('status')->equals('ONLINE')
            ->field("conteudos.atuacao.$estado")->in($cidade)
            ->select('conteudos.arquivos_publicos', 'alcunha', 'nascimento', 'username', 'conteudos.atuacao', 'selecionado') // Projeta apenas o campo 'email'
            ->getQuery()
            ->execute();
        $users = $qb->toArray();

        return $users;
    }

    public function buscaEspecifica(string $username): ?object
    {
        $qb = $this->dm->createQueryBuilder(User::class)
            ->field('username')->equals($username)
            ->select('conteudos.arquivos_publicos', 'alcunha', 'nascimento', 'username', 'celular', 'conteudos.atuacao');

        $query = $qb->getQuery();
        return $query->getSingleResult();
    }

    public function capturarLoc(array $coordenadas): array
    {

        try {

            $latitude = $coordenadas['latitude'];
            $longitude = $coordenadas['longitude'];

            $client = new Client();
            $response = $client->post("https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=" . $_ENV['GOOGLE_MAPS'], [
                'timeout' => 10,
            ]);
            $bb = $response->getBody()->getContents();
            $body = json_decode($bb, true);

            foreach ($body['results'] as $result) {
                foreach ($result['address_components'] as $component) {

                    if (in_array('administrative_area_level_2', $component['types'])) {
                        $cidade = $component['long_name'];
                    }

                    if (in_array('administrative_area_level_1', $component['types'])) {
                        $estado = $component['short_name'];
                    }
                }

                if ($cidade && $estado) {
                    break;
                }
            }

            if (!isset($cidade) || !isset($estado)) {
                throw new Exception("Não foi possível achar o estado ou cidade");
            }

            $buscas_gerais = $this->buscasGF(false, $estado, [$cidade]);

            $buscas_gerais['estado'] = $estado;
            $buscas_gerais['cidade'] = $cidade;

            return $buscas_gerais;
        } catch (\Throwable $d) {
            $cidade2 = !isset($cidade) ? false : $cidade;
            $estado2 = !isset($estado) ? false : $estado;
            $bb = !isset($bb) ? false : $bb;
            configureScope(function (Scope $scope) use ($d, $cidade2, $estado2, $bb) {
                $scope->setExtra('informcacao_adicional', 'Houve um problema ao adquirir a posição do usuário de forma autómática usando a api do google apis.
                Apesar do usuário ter cedido sua localização. O valor de cidade é: ' . ($cidade2 ? $cidade2 : 'não identificado') . '. e o valor de estado é: ' . ($estado2 ? $estado2 : 'não identificado') . '. O valor do retorno do google maps api é: ' . ($bb ? $bb : 'não identificado') . ' .');
            });
            captureException($d);

            return ['msg' => [530 => 'Houve um erro em capturar sua posiçao atual. Insira sua posição manualmente no formulário acima.']];
        }
    }
}
