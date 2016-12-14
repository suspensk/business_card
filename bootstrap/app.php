<?php
use Respect\Validation\Validator as v;
session_start();
require __DIR__ . '/../vendor/autoload.php';
//$user = new \App\Models\User;
//var_dump($user);
//die();
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slim',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ],
        'startTime' => microtime(true)
    ]
]);
$container = $app->getContainer();


$capsule = new Illuminate\Database\Capsule\Manager;
$capsule -> addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
};

/* mysqli */
//
//$mysqli = new mysqli("localhost", "root", "1", "slim");
//if (mysqli_connect_errno()) {
//    printf("Connect failed: %s\n", mysqli_connect_error());
//    exit();
//}
//$mysqli->set_charset("utf8");
//$result = $mysqli->query("SELECT email FROM users where id=1");
//if($result) {
//    while ($row = $result->fetch_object()) {
//        echo $row->email;
//    }
//}
//$mysqli->close();
/**/

$container['startTime'] = function ($container){
    return $container['settings']['startTime'];
};

$container['auth'] = function($container){
    return new \App\Auth\Auth;
};

$container['flash']= function ($container){
    return new \Slim\Flash\Messages;
};

$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views/site',[
        'cache' => false // on production = true
    ]);
    $view -> addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->getEnvironment()->addGlobal('auth',
        [
            'check' => $container->auth->check(),
            'user' => $container->auth->user(),
        ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};


$container['validator'] = function($container){
  return new App\Validation\Validator;
};

$container['HomeController'] = function($container){
   return new \App\Controllers\Site\HomeController($container);
};
$container['AuthController'] = function($container){
    return new \App\Controllers\Site\Auth\AuthController($container);
};
$container['PasswordController'] = function($container){
    return new \App\Controllers\Site\Auth\PasswordController($container);
};

$container['csrf'] = function($container){
    return new \Slim\Csrf\Guard;
};


$app->add(new App\Middleware\Site\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\Site\OldInputMiddleware($container));
$app->add(new App\Middleware\Site\CsrfViewMiddleware($container));
$app->add($container->csrf);

v::with('App\\Validation\\Rules');
require __DIR__ . '/../app/routes.php';
