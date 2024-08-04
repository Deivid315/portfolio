<?php

  namespace App\Controller;

use Exception;
use Psr\Log\LoggerInterface;
use Sentry\State\Scope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use function Sentry\captureException;
use function Sentry\configureScope;

  class SentryTestController extends AbstractController {
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
      $this->logger = $logger;
    }

    public function testLog(UserInterface $user)
    {
      try{
        if(4 != 2){
          throw new Exception('testando testando', 0);

        }
      }catch(Exception $e){
        configureScope(function (Scope $scope) use ($e, $user): void {
            $scope->setUser(['nome_completo' => $user->getNomeCompleto(), 'telefone' => $user->getCelular(), 'email' => $user->getEmail()]);
            $scope->setExtra('gggggggg', 'Algumas' . $user->getCelular() .' informações adiciofdsdfsfdfsfsfsdfsfdnais aqui');
      });
      captureException($e);

        return new Response('erro');
      }
    }
  }