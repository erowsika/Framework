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

    private $muser;

    public function __construct() {
        $this->muser = new model\User;
    }

    public function index() {
        $coba = \Sby::instance()->input->get('id',true);
        $this->coba = $coba;
        $this->display("welcome\isi.php");
    }

    public function beforeExecute() {
       
    }

}
