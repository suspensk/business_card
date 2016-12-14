<?php
namespace App\Middleware\Site;
class GuestMiddleware extends Middleware{

    public function __invoke($request, $response, $next){
        if($this->container->auth->check()){
        //    $this->container->flash->addMessage('error', 'Please sign in');
            return $response->withRedirect($this->container->router->pathFor('home'));
        }


        $response = $next($request, $response);
        return $response;
    }

}