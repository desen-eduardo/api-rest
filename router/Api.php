<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Autorization, Content-Type, x-xrsf-token, x_csrftoken,Cache-Control,X-Request-With');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Controllers\ProductController;

$app->group('/api',function(RouteCollectorProxy $group){
    
    $group->get('/product/all[/{page}]',ProductController::class.':index');
    $group->post('/product/register',ProductController::class.':create');
    $group->get('/product/edit/{id}',ProductController::class.':read');
    $group->put('/product/update',ProductController::class.':update');
    $group->delete('/product/delete',ProductController::class.':delete');

    $group->post('/user/register',UserController::class.':index');
    $group->post('/user/login',UserController::class.':logIn');

    $group->map(['GET'],'/{routes:.+}',function($request,$response){
        $response->getBody()->write(json_encode(['error'=>'Requisição não encontrada']));
        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
    });

});

$app->addErrorMiddleware(false, false, false);

