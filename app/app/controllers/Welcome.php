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
        
    }

    public function permission() {
        return array(
            'index' => array('cache' => false, 'allowed_user' => 'guest', 'admin'),
            'dokumentasi' => array('cache' => false, 'allowed_user' => 'guest', 'admin'),
            'classReference' => array('cache' => false, 'allowed_user' => 'guest', 'admin'));
    }

    /**
     * index page
     * @access public
     */
    public function index() {
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
