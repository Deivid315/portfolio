<?php

namespace App\Controllers;

use App\Models\Admin\Buscas\Buscas;
use App\Models\Admin\Token;
use App\Models\Admin\Salvar\Salvar;

class AdminController extends BaseController
{
    public function dashboard(): string
    {
        helper('form');

        $token = new Token();
        $mostre_token = $token->getToken();
        $msg = false;

        if ($this->request->is('post')) {

            $data = $this->request->getPost(['token']);

            if (! $this->validateData($data, [
                'token' => [
                    'label' => 'Token',
                    'rules' => 'required|alpha_numeric|min_length[100]|max_length[200]',
                    'errors' => [
                        'required' => 'O {field} é obrigatório.',
                        'alpha_numeric' => 'O {field} deve conter apenas letras e números.',
                        'max_length' => 'O {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'O {field} deve ter no mínimo 100 caracteres.',
                    ]
                ],
            ])) {
                return view('admin/dashboard', ['token' => $mostre_token['token']]);
            }

            $token->updateToken($this->validator->getValidated()['token']);
            $msg = 'token alterado com sucesso!';
            $mostre_token['token'] = $this->validator->getValidated()['token'];
        }

        return view('admin/dashboard', ['token' => $mostre_token['token'], 'alert' => $msg]);
    }

    public function info()
    {
        $request = service('request');

        if ($request->isAJAX()) {

            $index = $request->getJSON();

            $esco = $index->esco ?? null;
            $id = $index->det ?? null;
            $tabela = $index->es ?? null;
            if ($esco) {

                $escolas = new Buscas();
                $retorno = $escolas->getEscola($esco);

                $this->logger->alert('variavel é: ' . $esco);

                $response = [
                    'data' => $retorno,
                    'newCsrfToken' => csrf_hash(),
                ];

                return $this->response->setJSON($response);
            } else if ($tabela && $id) {

                $this->logger->alert("a tabela é: $tabela e o id é: $id");
                $detalhes = new Buscas();
                $det = $detalhes->getDetalhes($tabela, $id);

                $response = [
                    'data' => $det,
                    'newCsrfToken' => csrf_hash(),
                ];

                return $this->response->setJSON($response);
            }
        }
        $this->logger->alert('não é iajas');

        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }


    public function atualize()
    {
        try {
            $request = service('request');

            $this->logger->alert('foi');

            $json = $request->getJSON(true)['data'];

            $response = [
                'escola' => $json['escola'] ?? null,
                'estado' => $json['estado'] ?? null,
                'cidade' => $json['cidade'] ?? null,
                'matricula' => $json['matricula'] ?? null,
                'mv_3' => $json['mv_3'] ?? null,
                'mv_6' => $json['mv_6'] ?? null,
                'mv_9' => $json['mv_9'] ?? null,
                'mv_12' => $json['mv_12'] ?? null,
                'mc_3' => $json['mc_3'] ?? null,
                'mc_6' => $json['mc_6'] ?? null,
                'mc_9' => $json['mc_9'] ?? null,
                'mc_12' => $json['mc_12'] ?? null,
            ];

            // if (!empty($response['escola'])) {
            //     $regra_escola = 'required';
            // } else {
            //     $regra_escola = 'permit_empty';
            // }
            // if (!empty($response['estado'])) {
            //     $regra_estado = 'required';
            // } else {
            //     $regra_estado = 'permit_empty';
            // }
            // if (!empty($response['matricula'])) {
            //     $regra_matricula = 'required';
            // } else {
            //     $regra_matricula = 'permit_empty';
            // }
            // if (!empty($response['cidade'])) {
            //     $regra_cidade = 'required';
            // } else {
            //     $regra_cidade = 'permit_empty';
            // }

            if (! $this->validateData($response, [
                'escola' => [
                    'label' => 'Escola',
                    'rules' => 'required|alpha|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'É obrigatório a escolha de uma escola',
                        'alpha' => 'A {field} deve conter apenas letras.',
                        'max_length' => 'A {field} deve ter no máximo 50 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 2 caracteres.',
                    ]
                ],
                'estado' => [
                    'estado' => 'Estado',
                    'rules' => 'required|alpha|min_length[2]|max_length[4]',
                    'errors' => [
                        'required' => 'É obrigatório a escolha de um estado',
                        'alpha' => 'O {field} deve conter apenas letras.',
                        'max_length' => 'O {field} deve ter no máximo 4 caracteres.',
                        'min_length' => 'O {field} deve ter no mínimo 2 caracteres.',
                    ]
                ],
                'cidade' => [
                    'label' => 'Cidade',
                    'rules' => 'permit_empty|min_length[2]|max_length[200]',
                    'errors' => [
                        'max_length' => 'A {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 2 caracteres.',
                    ]
                ],
                'matricula' => [
                    'label' => 'Matricula',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'A {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 5 caracteres.',
                    ]
                ],
                'mc_3' => [
                    'label' => 'Comprovação do 1º mês + dependente',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'A {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 5 caracteres.',
                    ]
                ],
                'mc_6' => [
                    'label' => 'Comprovação do 2º mês + dependente',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'A {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 5 caracteres.',
                    ]
                ],
                'mc_9' => [
                    'label' => 'Comprovação do 3º mês + dependente',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'A {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 5 caracteres.',
                    ]
                ],
                'mc_12' => [
                    'label' => 'Comprovação do 4º mês + dependente',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'A {field} deve ter no máximo 200 caracteres.',
                        'min_length' => 'A {field} deve ter no mínimo 5 caracteres.',
                    ]
                ],
                'mv_3' => [
                    'label' => 'Valores do 1º mês',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'Os {field} devem ter no máximo 200 caracteres.',
                        'min_length' => 'Os {field} devem ter no mínimo 5 caracteres.',
                    ]
                ],
                'mv_6' => [
                    'label' => 'Valores do 2º mês',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'Os {field} devem ter no máximo 200 caracteres.',
                        'min_length' => 'Os {field} devem ter no mínimo 5 caracteres.',
                    ]
                ],
                'mv_9' => [
                    'label' => 'Valores do 3º mês',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'Os {field} devem ter no máximo 200 caracteres.',
                        'min_length' => 'Os {field} devem ter no mínimo 5 caracteres.',
                    ]
                ],
                'mv_12' => [
                    'label' => 'Valores do 4º mês',
                    'rules' => 'permit_empty|min_length[5]|max_length[200]',
                    'errors' => [
                        'max_length' => 'Os {field} devem ter no máximo 200 caracteres.',
                        'min_length' => 'Os {field} devem ter no mínimo 5 caracteres.',
                    ]
                ],
            ])) {
                $errors = $this->validator->getErrors();

                $errorMessages = implode("\n", $errors);

                $erros = [
                    'errorMessages' => $errorMessages,
                    'newCsrfToken' => csrf_hash(),
                ];

                return $this->response->setJSON($erros);
            } else {

                $alterar = new Salvar();
                $novo_response = array_filter($response, function($value) {
                    return $value !== null;
                });
                foreach ($novo_response as $name => $value) {
                    if ($name !== 'estado' && $name !== 'escola') {
                        $result = $alterar->setAlterar(
                            $novo_response['estado'],
                            $novo_response['escola'],
                            $name,
                            $value
                        );

                        if (!$result) {
                            $erros = [
                                'errorMessages' => 'Falha ao alterar o campo: ' . $name,
                                'newCsrfToken' => csrf_hash(),
                            ];

                            return $this->response->setJSON($erros);
                        }
                    }
                }

                $sucesso = [
                    'estado' => $response['estado'],
                    'mensagem' => 'Campo(s) atualizado(s) com sucesso',
                    'newCsrfToken' => csrf_hash(),
                ];

                return $this->response->setJSON($sucesso);
            }
        } catch (\Throwable $e) {

            $erros = [
                'errorMessages' => 'Houve um erro em nossos serviços. ' . $e->getMessage(),
                'newCsrfToken' => csrf_hash(),
            ];

            return $this->response->setJSON($erros);
        }
    }
}
