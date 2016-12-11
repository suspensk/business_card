<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
//$app->get('/home', function($request, $response){
//    return $this->view->render($response, 'home.twig');
//});

$app->get('/','HomeController:index')->setName('home');


$app->group('', function(){
    $this->get('/auth/signup','AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup','AuthController:postSignUp');

    $this->get('/auth/signin','AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin','AuthController:postSignIn');
})->add(new GuestMiddleware($container));






$app->group('', function(){
    $this->get('/auth/signout','AuthController:getSignOut')->setName('auth.signout');
    $this->get('/auth/password/change','PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change','PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));

/**/


$app->get('/{controller}/{action}', function ($request, $response, $args) use ($app)  {
  //  echo $args['controller'];
 //   var_dump($request->getParams());
    var_dump($args);

});

//$app->get('/:controller(/:action)/', function ($controller, $action = null) use ($app) {
//
//    var_dump($controller);
//    die();
//    $query = (object)$app->request->params();
//
//    $controller = ucfirst($controller) . 'Controller';
//
//    if (!class_exists($controller)) {
//        throw new InvalidArgumentException("The action controller '$controller' has not been defined.");
//    }
//    $controller = new $controller($query, $user, $detect, $logger);
//    if (!method_exists($controller, $action)) {
//        $action = 'index';
//        // throw new InvalidArgumentException("The method '$action' of '$controller' don't exists.");
//    }
//    $controller->{$action}();


//});

//$app->notFound(function () use ($app) {
//    var_dump($app->request);
//});
