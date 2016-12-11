<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;
//
//require '/../vendor/autoload.php';
//
//$app = new \Slim\App;
//
//require_once('/../app/api/books.php');
//require_once('/../app/api/MyController.php');
//require_once('/../app/api/Action.php');
//require_once('/../app/api/HelloWorldAction.php');
//require_once('/../app/api/mypage.php');
//
//$app->get('/', function($request, $response){
//    return 'home';
//});
//
//$app->run();


require __DIR__ . '/../bootstrap/app.php';
$app->run();