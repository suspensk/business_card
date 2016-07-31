<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;

// we extend a class that allows Controller-like behavior
class Pages extends Processor
{
    /**
     * The Builder will be used to access
     * various parts of the framework later on
     * @var Project\App\HTTPProcessors\Builder
     */
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    // This is the default action
    public function defaultAction(Request $request)
    {
        return $this->builder->components()->template()->get('app:hp', array(
           
        ));
    }
    public function viewAction(Request $request)
    {
        //Output the 'id' parameter
     //   return $request->attributes()->get('id');
//        if(is_null($this->builder->components()->auth()->domain()->user())){
//            return $this->redirectResponse(
//                'app.processor',
//                array('processor' => 'auth')
//            );
//        }
        $id = $request->attributes()->get('id');

        $orm = $this->builder->components()->orm();
        $str  = '';
        $page = $orm->query('page')->in($id)->findOne();


        $template = $this->builder->components()->template();
        return $template->render(
            'app:pages/view',
            array(
                'page' => $page
            )
        );
        //Output the 'id' parameter
        //    return $request->attributes()->get('id');
    }
    public function aboutAction(Request $request)
    {
        //Output the 'id' parameter
        //   return $request->attributes()->get('id');
//        if(is_null($this->builder->components()->auth()->domain()->user())){
//            return $this->redirectResponse(
//                'app.processor',
//                array('processor' => 'auth')
//            );
//        }
        $id = 1;

        $orm = $this->builder->components()->orm();
        $str  = '';
        $page = $orm->query('page')->in($id)->findOne();


        $template = $this->builder->components()->template();
        return $template->render(
            'app:pages/view',
            array(
                'page' => $page
            )
        );
        //Output the 'id' parameter
        //    return $request->attributes()->get('id');
    }
}