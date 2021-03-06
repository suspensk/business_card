<?php
use Respect\Validation\Validator as v;
session_start();
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../docs/config.php';
//$user = new \App\Models\User;
//var_dump($user);
//die();
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => DB_DRIVER,
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASSWORD,
            'charset' => DB_CHARSET,
            'collation' => DB_COLLATION,
            'prefix' => DB_PREFIX
        ],
        'startTime' => microtime(true),
        'upload_path' => 'uploads/',
        'max_upload_size' => 3145728, // in bytes = 3MB
        'picture_types' => array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        )
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
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views/admin',[
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
    return new \App\Controllers\Admin\HomeController($container);
};
$container['AuthController'] = function($container){
    return new \App\Controllers\Admin\Auth\AuthController($container);
};
$container['PasswordController'] = function($container){
    return new \App\Controllers\Admin\Auth\PasswordController($container);
};

$container['csrf'] = function($container){
    return new \Slim\Csrf\Guard;
};


$app->add(new App\Middleware\Admin\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\Admin\OldInputMiddleware($container));
$app->add(new App\Middleware\Admin\CsrfViewMiddleware($container));
$app->add($container->csrf);

v::with('App\\Validation\\Rules');
require __DIR__ . '/../app/routesAdmin.php';
