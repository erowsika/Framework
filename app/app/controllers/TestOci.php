<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core as app;
use app\models\Mysql;
use app\models\Oracle;

class TestOci extends app\Controller {

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
        $mysql = new Oracle();
        $tb = $mysql->showTableTest()->fetchArray();
        foreach ($tb as $value) {
            echo $value['TNAME'] . "<br>";
        }
    }

    public function column() {
        $mysql = new Oracle();
        $tb = $mysql->showColumnTest()->fetchArray();
        foreach ($tb as $value) {
            echo $value['Field']."  ".$value['Key']."<br>";
        }
    }

    public function insert() {
        $mysql = new Oracle();
        $tb = $mysql->insert();
       
    }
    
    public function update() {
        $mysql = new Oracle();
        $tb = $mysql->update();
       
    }
    
    public function delete() {
        $mysql = new Oracle();
        $tb = $mysql->delete();
       
    }
    
    public function select() {
        $mysql = new Oracle();
        $tb = $mysql->select();
        foreach ($tb as $value) {
            print_r($value);
            echo "<br>";
        }
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
