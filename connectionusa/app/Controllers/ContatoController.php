<?php

namespace App\Controllers;

use App\Models\Cliente\ProcessForm;

class ContatoController extends BaseController
{
    
    public function contato(): string
    {
        echo 'kkk'; exit;
        helper('form');

        if($this->request->is('post')){

            $data = $this->request->getPost(['email', 'nome', 'telefone', 'informacoes']);

            if (! $this->validateData($data, [
                'email' => [
                    'label' => 'E-mail',
                    'rules' => 'required|valid_email|max_length[100]',
                    'errors' => [
                        'required' => 'O {field} é obrigatório.',
                        'valid_email' => 'Por favor, insira um {field} válido.',
                        'max_length' => 'O {field} deve ter no máximo 100 caracteres.'
                    ]
                ],
                'nome' => [
                    'label' => 'Nome',
                    'rules' => 'required|alpha_space|max_length[50]|min_length[3]',
                    'errors' => [
                        'required' => 'O {field} é obrigatório.',
                        'alpha_space' => 'O {field} deve conter apenas letras e espaços.',
                        'max_length' => 'O {field} deve ter no máximo 50 caracteres.',
                        'min_length' => 'O {field} deve ter no mínimo 3 caracteres.'
                    ]
                ],
                'telefone' => [
                    'label' => 'Telefone',
                    'rules' => 'required|regex_match[/^\d{10,20}$/]',
                    'errors' => [
                        'required' => 'O {field} é obrigatório.',
                        'regex_match' => 'O {field} deve conter entre 10 e 20 dígitos.'
                    ]
                ],
                'informacoes' => [
                    'label' => 'Informações',
                    'rules' => 'required|max_length[600]|min_length[10]|trim',
                    'errors' => [
                        'required' => 'As {field} são obrigatórias.',
                        'max_length' => 'As {field} devem ter no máximo 600 caracteres.',
                        'min_length' => 'As {field} devem ter no mínimo 10 caracteres.',
                        'trim' => 'As {field} não podem ser apenas espaços em branco.'
                    ]
                ]
            ])) {
                return view('contato/contato');
            }            

            $post = $this->validator->getValidated();

            $model = model(ProcessForm::class);

            $result = $model->envie(
                $post['email'],
                $post['nome'],
                $post['telefone'],
                $post['informacoes']
            );

            return view('contato/contato', [
                'msg' => $result['msg'] ?? 'Mensagem enviada com sucesso!',
                'cor' => $result['cor'] ?? 'green'
            ]);

        }
        return view('contato/contato');
    }
    
    
}
