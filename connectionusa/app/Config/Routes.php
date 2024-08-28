<?php

use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */

 $routes->get('/', [HomeController::class,'home']);
 $routes->get('estude-nos-eua', [HomeController::class, 'estudenoseua']);
 $routes->match(['POST', 'GET'], 'contato', [HomeController::class, 'contato']);
 $routes->get('politica', [HomeController::class, 'politica']);
 $routes->match(['POST', 'GET'], 'dashboard', [AdminController::class, 'dashboard']);
 $routes->get('accessadmin', [LoginController::class, 'loginView']);
 $routes->get('logout', [LoginController::class, 'logoutAction']);
 $routes->post('accessadmin', [LoginController::class, 'loginActio']);
 $routes->post('detalhes/esc', [AdminController::class, 'info']);
 $routes->post('detalhes/atualize', [AdminController::class, 'atualize']);
 $routes->post('detalhes/escolas', [AdminController::class, 'escolas']);

$routes->set404Override(function() {
    $controller = new \App\Controllers\HomeController();
    return $controller->home();
});
service('auth')->routes($routes, ['except' => ['login', 'register']]);
