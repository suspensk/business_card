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
    }

    public function edit($request, $response){
        $params = $request->getParams();
        if(isset($params['id']) && is_numeric($params['id'])){
            $review= Review::find($params['id']);
            $this->view->getEnvironment()->addGlobal('review', $review);
            return $this->view->render($response, 'edit/review.twig');
        } else{
            return $response->withRedirect($this->router->pathFor('home'));
        }
    }

    public function add($request, $response){
        $params = $request->getParams();
         $review= null;
         $this->view->getEnvironment()->addGlobal('review', $review);
         return $this->view->render($response, 'edit/review.twig');

    }

    public function postEdit($request, $response){
        $params = $request->getParams();
        if(!empty($params['id'])){
            Review::setData($params);
            $this->flash->addMessage('success', 'Changes saved successfully!');
            return $response->withRedirect('view?id=' . $params['id']);
        } else{
            $newId = Review::addNew($params);
            $this->flash->addMessage('success', 'Record added successfully!');
            return $response->withRedirect('view?id=' . $newId);
        }
        var_dump($params);
        die();
//        if(isset($params['id']) && is_numeric($params['id'])){
//            $review= Review::find($params['id']);
//            $this->view->getEnvironment()->addGlobal('review', $review);
//            return $this->view->render($response, 'edit/review.twig');
//        }
    }
}