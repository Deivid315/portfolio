<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use App\Message\SmsNotification;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{
    public function asyncExample(Request $request, UserInterface $user): Response
    {
        
            $fv = ['fotosevideos' => [
             'publico' => $user->getConteudosDaConta()->getArquivosPrivados()['fotosevideos'],
             'privado' => $user->getConteudosDaConta()->getArquivosPrivados()['fotosevideos']['privado']]] ;
        


        $vv = [
            'detalhes' =>[
        'biografia' => 'teste de biografia agdsdfora',
        'valor' => 111,
        'altura' => '111 cm',
        'peso' => '111 kg',
        'local' => 'Meu local',
        'etnia' => 'Amarelo',
        'cabelo' => 'Azul',
        'posicao' => 'Versátil',
        'fetiches' => ['Fetiches com cosméticos']
            ]
        ];

        $mescle = array_merge($fv, $vv);


    $userData = [
        'sexualidade' => $user->getSexualidade(),
        'arquivos' => [ $mescle
        ]
    ];

        $client = new Client();
        $response = $client->post('http://localhost:3000/emit', [
            'json' => [
                'images' => 'teste de imagens',
                'texts' => $userData,
                'result' => true
            ]
        ]);
    

        return new Response('Mensagem enviada para a fila SQS.');
    }
}