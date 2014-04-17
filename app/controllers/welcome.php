<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

use app\core as app;
use app\models as model;

class welcome extends app\Controller {
    
    /**
     * constructor
     */
    public function __construct() {
       
    }
    
    /**
     * index page
     * @access public
     */
    public function index() {
        $this->display("welcome\index.php");
    }
    
    
    public function dokumentasi(){
        $this->display("welcome\dokumentasi.php");
    }
    
    
    public function classReference(){
        $this->display("welcome\classreference.php");
    }
    
    public function tentang(){
        $this->display("welcome\about.php");
    }
    
    
    /**
     * method before execution
     */
    public function beforeExecute() {
       
    }

    
    /**
     * method after execution
     */
    
    public function afterExcetion(){
        
        
    }
}
