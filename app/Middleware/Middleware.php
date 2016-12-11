<?php
namespace App\Middleware;
class Middleware{
    /**
     * @var \App\Controllers\Controller::container
     */
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

}