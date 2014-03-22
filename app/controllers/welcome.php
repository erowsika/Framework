<?php

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
namespace controllers;
use core as sys;

class welcome extends sys\BaseController{

    public function __construct() {
        
    }
    
    public function index(){
        echo 'masfu hisyam';
    }
}
