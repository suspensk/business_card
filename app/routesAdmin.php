<?php
use App\Middleware\Admin\AuthMiddleware;
use App\Middleware\Admin\GuestMiddleware;
//$app->get('/home', function($request, $response){
//    return $this->view->render($response, 'home.twig');
//});

$app->get('/admin/','HomeController:index')->setName('home');
