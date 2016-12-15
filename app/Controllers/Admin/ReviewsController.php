<?php
namespace App\Controllers\Admin;
use Slim\Views\Twig as View;
use \App\Models\Review;
class ReviewsController extends Controller{


    public function index($request, $response){
        $reviews= Review::all();
        $this->view->getEnvironment()->addGlobal('reviews', $reviews);
        return $this->view->render($response, 'content/reviews.twig');
        //  return 'Home controller';
    }

    public function view($request, $response){
        $params = $request->getParams();
        if(isset($params['id']) && is_numeric($params['id'])){
            $review= Review::find($params['id']);
            $this->view->getEnvironment()->addGlobal('review', $review);
            return $this->view->render($response, 'content/review.twig');
        }



        //  return 'Home controller';
    }
}