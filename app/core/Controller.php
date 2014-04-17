<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core;

/**
 * Description of Controller
 *
 * @author masfu
 */
use system\core as base;

class Controller extends base\BaseController {

    protected $layout = "layout\main.php";

    public function __construct() {
        parent::__construct();
    }

    public function display($file) {
        $this->content = $this->outputHtml($file);
        echo $this->outputHtml($this->layout);
    }

}
