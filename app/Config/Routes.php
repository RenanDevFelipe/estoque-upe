<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->options('api/(:any)', function($path){
    return service('response')
        ->setStatusCode(200)
        ->setHeader('Access-Control-Allow-Origin', '*') // ou seu domínio permitido
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->send();
});

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Auth
    $routes->post('auth/login', 'AuthController::login');

    // Produtos
    $routes->get('produtos', 'ProdutoController::index');
    $routes->get('produtos/(:num)', 'ProdutoController::show/$1');
    $routes->post('produtos', 'ProdutoController::create');
    $routes->put('produtos/(:num)', 'ProdutoController::update/$1');
    $routes->delete('produtos/(:num)', 'ProdutoController::delete/$1');

    // Movimentações
    $routes->get('movimentacoes', 'MovimentacaoController::index');
    $routes->post('movimentacoes', 'MovimentacaoController::create');

    // Relatórios
    $routes->get('relatorios/estoque', 'RelatorioController::estoqueResumo');
});

?>
