<?php
namespace App\Controllers\Site;
use Slim\Views\Twig as View;

class Controller{

    /**
     * @var \Interop\Container\ContainerInterface
     */
    private $container;

    /**
     * @var \App\Auth\Auth
     */
    private $auth;
    /**
     * @var \Slim\Flash\Messages
     */
    private $flash;
    /**
     * @var \Slim\Views\Twig
     */
    private $view;

    /**
     * @var \App\Validation\Validator
     */
    private $validator;
    /**
     * @var \Slim\Csrf\Guard
     */
    private $csrf;

    public  function  __construct($container){
        $this->container = $container;
    }
//    public function index($request, $response){
//        //   var_dump($request->getParam('name'));
//        return $this->view->render($response, 'home.twig');
//        //  return 'Home controller';
//    }

    public function __get($property){
        if($this->container->{$property}){
            return $this->container->{$property};
        }
    }
}