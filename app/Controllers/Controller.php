<?php
namespace App\Controllers;
use Slim\Views\Twig as View;

class Controller{

    /**
     * @var \Interop\Container\ContainerInterface
     */
  //  protected $container;

    /**
     * @var \App\Auth\Auth
     */
 //   public $auth;
    /**
     * @var \Slim\Flash\Messages
     */
 //   public $flash;
    /**
     * @var \Slim\Views\Twig
     */
  //  public $view;

    /**
     * @var \App\Validation\Validator
     */
  //  public $validator;
    /**
     * @var \Slim\Csrf\Guard
     */
  //  public $csrf;

    public  function  __construct($container){
        $this->container = $container;
    }
    public function index($request, $response){
        //   var_dump($request->getParam('name'));
        return $this->view->render($response, 'home.twig');
        //  return 'Home controller';
    }

    public function __get($property){
        if($this->container->{$property}){
            return $this->container->{$property};
        }
    }
}