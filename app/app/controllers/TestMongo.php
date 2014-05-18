<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core as app;
use app\models\MongoDb;

class TestMongo extends app\Controller {

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
        $mysql = new MongoDb();
        $tb = $mysql->showTableTest();
        print_r($tb);
    }

    public function column() {
        $mysql = new MongoDb();
        $tb = $mysql->showColumnTest();
        print_r($tb);
    }

    public function insert() {
        $mysql = new MongoDb();
        $tb = $mysql->insert();
       
    }
    
    public function update() {
        $mysql = new MongoDb();
        $tb = $mysql->update();
       
    }
    
    public function delete() {
        $mysql = new Mysql();
        $tb = $mysql->delete();
       
    }
    
    public function select() {
        $mysql = new MongoDb();
        $tb = $mysql->select();
        print_r($tb);
    }

    public function tentang() {
        $this->display("welcome\about.php");
    }

    /**
     * method before execution
     */
    public function beforeExecute() {
        
    }

    /**
     * method after execution
     */
    public function afterExcetion() {
        
    }

}
