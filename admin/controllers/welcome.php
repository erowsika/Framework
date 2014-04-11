<?php

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace controllers;

use core;
use models;

class welcome extends core\BaseController {

    private $muser;

    public function __construct() {
        $this->muser = new \models\User;
    }

    public function index() {
        echo 'masfu hisyam';
    }

}
