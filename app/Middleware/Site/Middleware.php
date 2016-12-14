<?php
namespace App\Middleware\Site;
class Middleware{
    /**
     * @var \App\Controllers\Site\Controller::container
     */
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

}