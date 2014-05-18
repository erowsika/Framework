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
use system\helper\Pagination;


class testPaging extends Controller{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $paging = new Pagination();
        $paging->baseUrl = App::instance()->base_url."testPaging";
        $paging->total = 100;
        $paging->current = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        $paging->limit = 10;
        $this->paging = $paging->render();
        $this->display("paging/test.php");
        
    }
}
