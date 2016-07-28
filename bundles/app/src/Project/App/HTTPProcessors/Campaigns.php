<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;

// we extend a class that allows Controller-like behavior
class Campaigns extends Processor
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
        return "Campaigns tutorial s";
    }

    public function get_citiesAction(Request $request)
    {
        $data = $request->data();
        $id = $data->get('country');
        if(!empty($id) && is_numeric($id)){
            $orm = $this->builder->components()->orm();
            $cities = $orm->query('city')->where('country', $id)->orderDescendingBy('id')->find()->asArray(true);
        }
        return (json_encode($cities));
    }

    public function get_countriesAction(Request $request)
    {
        $data = $request->data();
      //  $id = $data->get('country');
     //   if(!empty($id) && is_numeric($id)){
            $orm = $this->builder->components()->orm();
            $countries = $orm->query('country')->orderDescendingBy('id')->find()->asArray(true);
     //   }
        return (json_encode($countries));
    }

    public function get_mediumsAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $countries = $orm->query('medium')->orderDescendingBy('id')->find()->asArray(true);
        return (json_encode($countries));
    }

    public function get_publishersAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $countries = $orm->query('publisher')->orderDescendingBy('id')->find()->asArray(true);
        return (json_encode($countries));
    }

    public function get_payment_termsAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $countries = $orm->query('payment_term')->orderDescendingBy('id')->find()->asArray(true);
        return (json_encode($countries));
    }

    public function get_repsAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $countries = $orm->query('rep')->orderDescendingBy('id')->find()->asArray(true);
        return (json_encode($countries));
    }

    public function get_compensationsAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $countries = $orm->query('compensation')->orderDescendingBy('id')->find()->asArray(true);
        return (json_encode($countries));
    }

    public function get_pagesAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
        $countries = $orm->query('page')->orderDescendingBy('id')->find()->asArray(true);
        return (json_encode($countries));
    }

    public function get_campaign_pagesAction(Request $request)
    {
        $data = $request->data();
        $id = $data->get('campaign');
        $defaultPage = $data->get('default');
        if(!empty($id) && is_numeric($id)){
            $orm = $this->builder->components()->orm();
            $pages = $orm->query('page')->relatedTo('campaigns', $id)->orderDescendingBy('id')->find()->asArray(true);
            $arrResultPages = array();
            foreach($pages as $page){
            if($page->id == $defaultPage){
                array_unshift($arrResultPages, $page);
            } else{
                $arrResultPages[] = $page;
            }
            }

            $template = $this->builder->components()->template();
            return $template->render(
                'app:campaigns/pages',
                array(
                    'pages' =>  $arrResultPages,
                    'campaign_id' => $id
                ));
        }
        return '';
    }

    public function newAction(Request $request)
    {
        if(is_null($this->builder->components()->auth()->domain()->user())){
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'auth')
            );
        }
    //    $id = $request->attributes()->get('id');

        $orm = $this->builder->components()->orm();
        $str  = '';
     //   $campaign = $orm->query('campaign')->in($id)->findOne();

        $allCountries = $orm->query('country')->orderDescendingBy('id')->find()->asArray(true);
        $mediums = $orm->query('medium')->orderDescendingBy('id')->find()->asArray(true);
        $publishers = $orm->query('publisher')->orderDescendingBy('id')->find()->asArray(true);
        $compensations = $orm->query('compensation')->orderDescendingBy('id')->find()->asArray(true);
        $payment_terms = $orm->query('payment_term')->orderDescendingBy('id')->find()->asArray(true);
        $reps = $orm->query('rep')->orderDescendingBy('id')->find()->asArray(true);
        $pages = $orm->query('page')->orderDescendingBy('id')->find()->asArray(true);
        $countryCities = array();
      /*  if($campaign->country()){
            $countryCities = $orm->query('city')->where('country', $campaign->country()->id)->find()->asArray(true);
        }*/

        //   var_dump($allCountries);
        //    die();
        $template = $this->builder->components()->template();
        return $template->render(
            'app:campaigns/view',
            array(
            //    'campaign' => $campaign,
                'countries' => $allCountries,
                'cities' => $countryCities,
                'mediums' => $mediums,
                'publishers' => $publishers,
                'compensations' => $compensations,
                'payment_terms' => $payment_terms,
                'reps' => $reps,
                'pages' => $pages,
                'user' =>  $this->builder->components()->auth()->domain()->user()
            )
        );
        //Output the 'id' parameter
        //    return $request->attributes()->get('id');
    }

    public function viewAction(Request $request)
    {
        if(is_null($this->builder->components()->auth()->domain()->user())){
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'auth')
            );
        }
        $id = $request->attributes()->get('id');

        $orm = $this->builder->components()->orm();
        $str  = '';
        $campaign = $orm->query('campaign')->in($id)->findOne();

        $allCountries = $orm->query('country')->orderDescendingBy('id')->find()->asArray(true);
        $mediums = $orm->query('medium')->orderDescendingBy('id')->find()->asArray(true);
        $publishers = $orm->query('publisher')->orderDescendingBy('id')->find()->asArray(true);
        $compensations = $orm->query('compensation')->orderDescendingBy('id')->find()->asArray(true);
        $payment_terms = $orm->query('payment_term')->orderDescendingBy('id')->find()->asArray(true);
        $reps = $orm->query('rep')->orderDescendingBy('id')->find()->asArray(true);
        $pages = $orm->query('page')->orderDescendingBy('id')->find()->asArray(true);
        $countryCities = array();
        if($campaign->country()){
            $countryCities = $orm->query('city')->where('country', $campaign->country()->id)->orderDescendingBy('id')->find()->asArray(true);
        }

     //   var_dump($allCountries);
    //    die();
        $template = $this->builder->components()->template();
        return $template->render(
            'app:campaigns/view',
            array(
                'campaign' => $campaign,
                'countries' => $allCountries,
                'cities' => $countryCities,
                'mediums' => $mediums,
                'publishers' => $publishers,
                'compensations' => $compensations,
                'payment_terms' => $payment_terms,
                'reps' => $reps,
                'pages' => $pages,
                'user' =>  $this->builder->components()->auth()->domain()->user()
            )
        );
        //Output the 'id' parameter
    //    return $request->attributes()->get('id');
    }

    /* OLD WITHOUT AJAX */
    public function saveAction(Request $request)
    {
        if (is_null($this->builder->components()->auth()->domain()->user())) {
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'auth')
            );
        }
        $data = $request->data();
        $id = $data->get('id');
        $validator = $this->getCampaignValidator();
        $result = $validator->validate($data->get());
        if(!$result->isValid()) {
            foreach ($result->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $_SESSION['errors'][] = $fieldResult->path() . ": " . $error;
                }
            }
        }

        if(!$result->isValid()) {
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'campaigns/view/' . $id)
            );
        }


        $orm = $this->builder->components()->orm();
        $campaignRepository = $orm->repository('campaign');
        $campaignRepository->query()
            ->where('id', $id)
            ->update(array(
            //    'name' => $data->get('name'),
                'country' => $data->get('country'),
                'city' => $data->get('city'),
                'medium' => $data->get('medium'),
                'publisher' => $data->get('publisher'),
                'compensation' => $data->get('compensation'),
                'payment_term' => $data->get('payment_term'),
                'default_page' => $data->get('page'),
                'rep' => $data->get('rep'),
                'product' => $data->get('product'),
                'ad_group' => $data->get('ad_group'),
                'paid' => $data->get('paid'),
                'rate' => $data->get('rate'),
                'start' => $data->get('start'),
                'end' => $data->get('end'),
                'remarks' => $data->get('remarks')

            ));
        return $this->redirectResponse(
            'app.processor',
            array('processor' => 'campaigns/list')
        );

    }

    public function editAction(Request $request)
    {
        $fieldNames = array('page' => 'Default landing page', 'multi_page' => 'Landing pages');
        if (is_null($this->builder->components()->auth()->domain()->user())) {
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'auth')
            );
        }
        $data = $request->data()->get('data');
        parse_str($data, $searchArray);


        $validator = $this->getCampaignValidator();
        $resultValidation = $validator->validate($searchArray);
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errField = isset($fieldNames[$fieldResult->path()]) ? $fieldNames[$fieldResult->path()]  : $fieldResult->path();

                    $errorArr[] = $errField . ": " . $error;
                }
            }
        } else {
            $orm = $this->builder->components()->orm();
            $campaignRepository = $orm->repository('campaign');
            $campaign = $campaignRepository->query()
                ->where('id', $searchArray['id'])
                ->update(array(
                //    'name' => $searchArray['name'],
                    'country' => !empty($searchArray['country']) ? $searchArray['country'] : null,
                    'city' => !empty($searchArray['city']) ? $searchArray['city'] : null,
                    'medium' => !empty($searchArray['medium']) ? $searchArray['medium'] : null,
                    'publisher' => !empty($searchArray['publisher']) ? $searchArray['publisher'] : null,
                    'compensation' => !empty($searchArray['compensation']) ? $searchArray['compensation'] : null,
                    'payment_term' => !empty($searchArray['payment_term']) ? $searchArray['payment_term'] : null,
                    'default_page' => $searchArray['page'],
                    'rep' => !empty($searchArray['rep']) ? $searchArray['rep'] : null,
                    'product' => $searchArray['product'],
                    'ad_group' => $searchArray['ad_group'],
                    'paid' => $searchArray['paid'],
                    'rate' => $searchArray['rate'],
                    'start' => !empty($searchArray['start']) ? $searchArray['start'] : null,
                    'end' => !empty($searchArray['end']) ? $searchArray['end'] : null,
                    'remarks' => $searchArray['remarks']

                ));

            if(!empty($searchArray['multi_page'])){
                $landing_pages = $searchArray['multi_page'];
                $pagesRepository = $orm->repository('page');
                $landing_pages = $pagesRepository->query()
                    ->in($landing_pages);

                $campaign->pages->removeAll()->add($landing_pages);
            }

        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function addAction(Request $request)
    {
        $fieldNames = array('page' => 'Default landing page', 'multi_page' => 'Landing pages');
        $newId = 0;
        if (is_null($this->builder->components()->auth()->domain()->user())) {
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'auth')
            );
        }
        $data = $request->data()->get('data');
        parse_str($data, $searchArray);


        $validator = $this->getCampaignValidator();
        $resultValidation = $validator->validate($searchArray);
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errField = isset($fieldNames[$fieldResult->path()]) ? $fieldNames[$fieldResult->path()]  : $fieldResult->path();

                    $errorArr[] = $errField . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $campaignRepository = $orm->repository('campaign');
            $campaign = $campaignRepository->create(array(
            //    'name' => $searchArray['name'],
                'country' => !empty($searchArray['country']) ? $searchArray['country'] : null,
                'city' => !empty($searchArray['city']) ? $searchArray['city'] : null,
                'medium' => !empty($searchArray['medium']) ? $searchArray['medium'] : null,
                'publisher' => !empty($searchArray['publisher']) ? $searchArray['publisher'] : null,
                'compensation' => !empty($searchArray['compensation']) ? $searchArray['compensation'] : null,
                'payment_term' => !empty($searchArray['payment_term']) ? $searchArray['payment_term'] : null,
                'default_page' => $searchArray['page'],
                'rep' => !empty($searchArray['rep']) ? $searchArray['rep'] : null,
                'product' => $searchArray['product'],
                'ad_group' => $searchArray['ad_group'],
                'paid' => $searchArray['paid'],
                'rate' => $searchArray['rate'],
                'start' => !empty($searchArray['start']) ? $searchArray['start'] : null,
                'end' => !empty($searchArray['end']) ? $searchArray['end'] : null,
                'remarks' => $searchArray['remarks']

            ));



//All this will b achieved with a single query to the database
            $campaign->save();
            if(!empty($searchArray['multi_page'])){
                $landing_pages = $searchArray['multi_page'];
                $pagesRepository = $orm->repository('page');
                $landing_pages = $pagesRepository->query()
                    ->in($landing_pages);
                $campaign->pages->add($landing_pages);
            }


            $newId = $campaign->id;
        }


        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => $newId));

    }

    public function listAction(Request $request)
    {
        if(is_null($this->builder->components()->auth()->domain()->user())){
            return $this->redirectResponse(
                'app.processor',
                array('processor' => 'auth')
            );
        }
        $orm = $this->builder->components()->orm();
        $campaigns = $orm->query('campaign')->find();
        $template = $this->builder->components()->template();
        return $template->render(
            'app:campaigns/list',
            array(
                'campaigns' => $campaigns,
                'user' =>  $this->builder->components()->auth()->domain()->user()
            )
        );
    }

    public function add_countryAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('country');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $countryRepository = $orm->repository('country');
            try{
            $newEntity = $countryRepository
                ->create(array('name' => $name))
                ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_countryAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('country');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $countryRepository = $orm->repository('country');
            try{
                $countryRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_countryAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $countryRepository = $orm->repository('country');
            try{
                $countryRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function add_cityAction(Request $request){
        $data = $request->data();
        $validator = $this->getCityValidator();
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $country = $data->get('country');
            $cityRepository = $orm->repository('city');
            try{
                $newEntity = $cityRepository
                    ->create(array('name' => $name, 'country' => $country))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_cityAction(Request $request){
        $data = $request->data();
        $validator = $this->getCityValidator();
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $country = $data->get('country');
            $cityRepository = $orm->repository('city');
            try{
                $cityRepository
                    ->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_cityAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $countryRepository = $orm->repository('city');
            try{
                $countryRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }


    public function add_mediumAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('medium');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $mediumRepository = $orm->repository('medium');
            try{
                $newEntity = $mediumRepository
                    ->create(array('name' => $name))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_mediumAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('medium');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $mediumRepository = $orm->repository('medium');
            try{
                $mediumRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_mediumAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $mediumRepository = $orm->repository('medium');
            try{
                $mediumRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function add_publisherAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('publisher');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $publisherRepository = $orm->repository('publisher');
            try{
                $newEntity = $publisherRepository
                    ->create(array('name' => $name))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_publisherAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('publisher');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $publisherRepository = $orm->repository('publisher');
            try{
                $publisherRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_publisherAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $publisherRepository = $orm->repository('publisher');
            try{
                $publisherRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function add_payment_termAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('payment_term');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $payment_termRepository = $orm->repository('payment_term');
            try{
                $newEntity = $payment_termRepository
                    ->create(array('name' => $name))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_payment_termAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('payment_term');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $payment_termRepository = $orm->repository('payment_term');
            try{
                $payment_termRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_payment_termAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $payment_termRepository = $orm->repository('payment_term');
            try{
                $payment_termRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function add_repAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('rep');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $repRepository = $orm->repository('rep');
            try{
                $newEntity = $repRepository
                    ->create(array('name' => $name))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_repAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('rep');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $repRepository = $orm->repository('rep');
            try{
                $repRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_repAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $repRepository = $orm->repository('rep');
            try{
                $repRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function add_compensationAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('compensation');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $compensationRepository = $orm->repository('compensation');
            try{
                $newEntity = $compensationRepository
                    ->create(array('name' => $name))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_compensationAction(Request $request){
        $data = $request->data();
        $validator = $this->getSimpleValidator('compensation');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $compensationRepository = $orm->repository('compensation');
            try{
                $compensationRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('name' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_compensationAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $compensationRepository = $orm->repository('compensation');
            try{
                $compensationRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function add_pageAction(Request $request){
        $data = $request->data();
        $validator = $this->getPageValidator('page');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $pageRepository = $orm->repository('page');
            try{
                $newEntity = $pageRepository
                    ->create(array('url' => $name))
                    ->save();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr, 'id' => !empty($newEntity) ? $newEntity->id : 0));
    }

    public function edit_pageAction(Request $request){
        $data = $request->data();
        $validator = $this->getPageValidator('page');
        $resultValidation = $validator->validate($data->get());
        $errorArr = '';
        $result = 0;
        if(!$resultValidation->isValid()) {
            $result = 1;
            foreach ($resultValidation->invalidFields() as $fieldResult) {
                foreach ($fieldResult->errors() as $error) {
                    $errorArr[] = $fieldResult->path() . ": " . $error;
                }
            }
        } else{
            $orm = $this->builder->components()->orm();
            $name = $data->get('name');
            $pageRepository = $orm->repository('page');
            try{
                $pageRepository->query()
                    ->where('id', $data->get('id'))
                    ->update(array('url' => $name));
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }

    public function delete_pageAction(Request $request){
        $data = $request->data();
        $errorArr = '';
        $result = 0;
        if(!(is_numeric($data->get('id'))) || $data->get('id') == 0) {
            $result = 1;
            $errorArr[] = 'Wrong id' . $data->get('id');
        } else{
            $orm = $this->builder->components()->orm();
            $pageRepository = $orm->repository('page');
            try{
                $pageRepository->query()
                    ->where('id', $data->get('id'))
                    ->delete();
            }catch(\Exception $e){
                $result = 2;
                $errorArr[] =  $e->getMessage();
            }
        }
        return json_encode(array('result' => $result, 'errors' => $errorArr));
    }


    /**
     * Builds a validator for the signup form
     * @return \PHPixie\Validate\Validator
     */
    protected function getCampaignValidator()
    {
        $validator = $this->builder->components()->validate()->validator();
        /** @var Document $document */
        $document = $validator->rule()->addDocument();
        $document->allowExtraFields();

//        $document->valueField('name')
//            ->required();

        $document->valueField('medium')
            ->required()
            ->filter('numeric');

        $document->valueField('publisher')
            ->required()
            ->filter('numeric');

        $document->valueField('paid')
            ->required()
            ->callback(function($result, $value) {
                if(!in_array($value, array('free', 'paid'))) {
                    $result->addMessageError("compensation can be either 'free' or 'paid'");
                }
            });
        $document->valueField('page')
            ->required()
            ->filter('numeric');
        $document->valueField('multi_page')
            ->required();

        $document->valueField('id')
            ->filter('numeric');

      //  $document->valueField('product')
      //      ->required();
            /*->callback(function($result, $value) {
                if(!in_array($value, array('fairy', 'pixie'))) {
                    // Задаем свою ошибку
                    $result->addMessageError("product can be either 'fairy' or 'pixie'");
                }
            });*/
        return $validator;
    }

    /**
     * Builds a validator for the signup form
     * @return \PHPixie\Validate\Validator
     */
    protected function getSimpleValidator($repository)
    {
        $validator = $this->builder->components()->validate()->validator();
        /** @var Document $document */
        $document = $validator->rule()->addDocument();
        $document->allowExtraFields();

        $document->valueField('name')
            ->required()
            ->callback(function($result, $value) use ($repository){
                if ($result->isValid()) {
                    $orm = $this->builder->components()->orm();
                    $countryRepository = $orm->repository($repository);
                    $country = $countryRepository->query()
                        ->where('name', $value)
                        ->findOne();

                    if ($country !== null) {
                        $result->addCustomError('Name already exists');
                    }
                }
            });

        $document->valueField('id')
            ->callback(function($result, $value) {
                    if (!(is_numeric($value)) || $value == 0) {
                        $result->addCustomError('Wrong id' . $value);
                    }

            });
        return $validator;
    }

    /**
     * Builds a validator for the signup form
     * @return \PHPixie\Validate\Validator
     */
    protected function getPageValidator($repository)
    {
        $validator = $this->builder->components()->validate()->validator();
        /** @var Document $document */
        $document = $validator->rule()->addDocument();
        $document->allowExtraFields();

        $document->valueField('name')
            ->required()
            ->filter('url')
            ->callback(function($result, $value) use ($repository){
                if ($result->isValid()) {
                    $orm = $this->builder->components()->orm();
                    $countryRepository = $orm->repository($repository);
                    $country = $countryRepository->query()
                        ->where('url', $value)
                        ->findOne();

                    if ($country !== null) {
                        $result->addCustomError('URL already exists');
                    }
                }
            });

        $document->valueField('id')
            ->callback(function($result, $value) {
                if (!(is_numeric($value)) || $value == 0) {
                    $result->addCustomError('Wrong id' . $value);
                }

            });
        return $validator;
    }

    /**
     * Builds a validator for the signup form
     * @return \PHPixie\Validate\Validator
     */
    protected function getCityValidator()
    {
        $validator = $this->builder->components()->validate()->validator();
        /** @var Document $document */
        $document = $validator->rule()->addDocument();
        $document->allowExtraFields();

        $document->valueField('name')
            ->required();


        $validator->rule()->callback(function ($result, $data) {
            if ($result->field('name')->isValid()) {

                $orm = $this->builder->components()->orm();
                $cityRepository = $orm->repository('city');
                $city = $cityRepository->query()
                    ->where('name', $data['name'])
                    ->and('country', $data['country'])
                    ->findOne();

                if ($city !== null) {
                    $result->field('name')->addCustomError('city name already exists in this country');
                }
            }

        });


        return $validator;
    }


}