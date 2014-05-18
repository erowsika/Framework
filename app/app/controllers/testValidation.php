<<<<<<< HEAD
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use \App;
use system\helper\Validator;
use app\core\Controller;

class TestValidation extends Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function validationRules() {
        return array(
            'name' => 'type:string|min:5|max:8|required:true|trim:true',
            'umur' => 'type:number|min:0|max:10|required:true|trim:true',
            'jk' => 'type:boolean|min:0|max:10|required:true|trim:true',
            'alamat' => 'type:number|min:0|max:10|required:true|trim:true',
            'url' => 'type:url|required:true|trim:true');
    }

    public function index() {

        $attributes = array(
            'name' => 'masfu',
            'umur' => '1',
            'jk' => '1',
            'alamat' => 'babat jerawat',
            'url' => 'http://babat.com');

        $validator = new Validator();
        $validator->addRules($this->validationRules());
        $validator->setAttributes($attributes);
        if($validator->validate() == true){
         echo 'fsfs';   
        }
        print_r($validator->getErrors());
    }

}
=======
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use \Sby;
use system\helper\Validator;
use app\core\Controller;

class TestValidation extends Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function validationRules() {
        return array(
            'name' => 'type:string|min:5|max:8|required:true|trim:true',
            'umur' => 'type:number|min:0|max:10|required:true|trim:true',
            'jk' => 'type:boolean|min:0|max:10|required:true|trim:true',
            'alamat' => 'type:number|min:0|max:10|required:true|trim:true',
            'url' => 'type:url|required:true|trim:true');
    }

    public function index() {

        $attributes = array(
            'name' => 'masfu',
            'umur' => '1',
            'jk' => '1',
            'alamat' => 'babat jerawat',
            'url' => 'http://babat.com');

        $validator = new Validator();
        $validator->addRules($this->validationRules());
        $validator->setAttributes($attributes);
        if($validator->validate() == true){
         echo 'fsfs';   
        }
        print_r($validator->getErrors());
    }

}
>>>>>>> b712582a47ecad6b4a21913d50954f94eea2aac0
