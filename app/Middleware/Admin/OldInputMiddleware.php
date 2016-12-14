<?php
namespace App\Middleware\Admin;
class OldInputMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

        $this->container->view->getEnvironment()->addGlobal('old', (isset($_SESSION['old']) ? $_SESSION['old'] : null));
      //  $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();
        $response = $next($request, $response);
        return $response;
    }

}