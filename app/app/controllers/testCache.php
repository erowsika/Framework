<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use \App;
use app\core\Controller;

class TestCache extends Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = App::instance()->cache->get('index');
        echo $data;
        if (!$data) {
            echo "buat";
            App::instance()->cache->set('index', 'aakfakfahfhfafhakf', 5);
        }
    }

}
