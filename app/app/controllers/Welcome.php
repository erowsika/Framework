<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core\Controller;

class Welcome extends Controller {

    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * index page
     * @access public
     */
    public function index() {
      //  self::enqueueScriptFile('assets/js/boostrap.js');
       // self::enqueueStyleFile('assets/css/boostrap.css');
        $this->display("welcome\index.php");
    }

    public function dokumentasi() {
	    $this->display("welcome\dokumentasi.php");
    }

    public function classReference() {
        $this->display("welcome\classreference.php");
    }

    public function tentang() {
        $this->display("welcome\about.php");
    }

}
