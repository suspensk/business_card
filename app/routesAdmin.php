<?php
use App\Middleware\Admin\AuthMiddleware;
use App\Middleware\Admin\GuestMiddleware;
//$app->get('/home', function($request, $response){
//    return $this->view->render($response, 'home.twig');
//});



$app->group('', function(){

    $this->get('/admin/','HomeController:index')->setName('home');
    $this->get('/admin/auth/signout','AuthController:getSignOut')->setName('auth.signout');
    $this->get('/admin/auth/password/change','PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/admin/auth/password/change','PasswordController:postChangePassword');

    $this->get('/admin/{controller}/{action}', function ($request, $response, $args) {
    //    $query = (object)$request->params();
        $controller = ucfirst($args['controller']);
//        var_dump($args);
//        die();

	if (!class_exists('\App\Controllers\Admin\\' . $controller . 'Controller')) {
        echo $controller;
      //  throw new InvalidArgumentException("The action controller '$controller' has not been defined.");
    } else{
        echo 'YES';
    }
//	$controller = new $controller($query, $user);
//	$controller = new $controller($query, $user, $detect, $logger);
//	if (!method_exists($controller, $action)) {
//        throw new InvalidArgumentException("The method '$action' of '$controller' don't exists.");
//        $action = 'index';
//        // throw new InvalidArgumentException("The method '$action' of '$controller' don't exists.");
//    }
//	$controller->{$action}();

    });

    $this->get('/admin/{controller}', function ($request, $response, $args) {
        var_dump($args);
        die();

    });






})->add(new AuthMiddleware($container));



//$app->group('', function(){
//    $this->get('/admin/auth/signup','AuthController:getSignUp')->setName('auth.signup');
//    $this->post('/admin/auth/signup','AuthController:postSignUp');
//
//    $this->get('/admin/auth/signin','AuthController:getSignIn')->setName('auth.signin');
//    $this->post('/admin/auth/signin','AuthController:postSignIn');
//})->add(new GuestMiddleware($container));


/**/


//$app->get('/{controller}/{action}', function ($request, $response, $args) use ($app)  {
//  //  echo $args['controller'];
// //   var_dump($request->getParams());
//    var_dump($args);
//
//});

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
