<?php
namespace App\Middleware\Admin;
class ValidationErrorsMiddleware extends Middleware{

    public function __invoke($request, $response, $next){
      //  var_dump('middleware');
        $this->container->view->getEnvironment()->addGlobal('errors', (isset($_SESSION['errors']) ? $_SESSION['errors'] : null));
        unset($_SESSION['errors']);
        $response = $next($request, $response);
        return $response;
    }

}