<?php
namespace App\Controllers;
use Slim\Views\Twig as View;
 use \App\Models\User;
class HomeController extends Controller{


    public function index($request, $response){
      //  $user = User::find(1);
    //    $user = User::where('email','vet4ina@rambler.ru')->first();
     //   var_dump($user->email);

     //   $time = microtime(true) - $this->startTime;
     //   printf('Script working time  %.4F сек.', $time);
     //   die();

     //   $user = $this->db->table('users')->find(1);
    //    var_dump($user->email);
//        User::create([
//            'name' => 'Alex Garrer',
//            'email' => 'ddfdf@ere.ty',
//            'password' => '123'
//        ]);


     //   var_dump($request->getParam('name'));

     //   $this->flash->addMessage('error','Test');
        return $this->view->render($response, 'home.twig');
      //  return 'Home controller';
    }
}