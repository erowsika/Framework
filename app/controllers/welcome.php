<?php

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
namespace controllers;
use core;

class welcome extends core\BaseController{

    public function __construct() {
        
    }
    
    public function index(){
        echo 'masfu hisyam';
    }
}
