<?php
namespace App\Controllers\Admin;
use Slim\Views\Twig as View;
use \App\Models\Review;
class ReviewsController extends Controller{


    public function index($request, $response){
        $reviews= Review::all();
        $this->view->getEnvironment()->addGlobal('reviews', $reviews);
        return $this->view->render($response, 'templates/content.twig');
        //  return 'Home controller';
    }
}