<?php
namespace App\Controllers\Admin\Auth;
use App\Controllers\Site\Controller;
use \App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends Controller{

    public function getSignOut($request, $response){

        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn($request, $response){
        return $this->view->render($response, 'auth/signin.twig');
    }

    public function postSignIn($request, $response){
       $auth = $this->auth->attempt(
           $request->getParam('email'),
           $request->getParam('password')
       );

        if(!$auth){
            $this->flash->addMessage('error', 'Could not sign!');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        $this->flash->addMessage('info', 'You have been signed up!');
        return $response->withRedirect($this->router->pathFor('home'));
    }


 public function getSignUp($request, $response){
   //  var_dump($request->getAttribute('csrf_value'));
    return $this->view->render($response, 'auth/signup.twig');
 }

    public function postSignUp($request, $response){
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),

        ]);
        if($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }
        $user = User::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT, ['cost' => 10]),
        ]);
        $this->flash->addMessage('info', 'You have been signed up!');
        $this->auth->attempt($user->email, $request->getParam('password'));
        return $response->withRedirect($this->router->pathFor('home'));
      //  var_dump($request->getParams());
    }
}