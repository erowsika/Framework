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
use system\core\BaseController;

class Controller extends BaseController {

    protected $layout = "layout\main.php";

    public function __construct() {
        parent::__construct();
    }
    
    public function beforeExecute() {
       // print_r(\Sby::instance()->session);
    }

    public function afterExecute() {
        
    }

}
