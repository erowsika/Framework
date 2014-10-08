<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core\Controller;

class WelcomeController extends Controller {

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
        $this->display("welcome\index.php");
    }

    public function dokumentasi() {
        $this->display("welcome\dokumentasi.php");
    }

    public function referense() {
        $this->display("welcome\classreference.php");
    }

    public function tentang() {
        $this->display("welcome\about.php");
    }

}
