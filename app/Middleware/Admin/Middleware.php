<?php
namespace App\Middleware\Admin;
class Middleware{
    /**
     * @var \App\Controllers\Site\Controller::container
     */
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

}