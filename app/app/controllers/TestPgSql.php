<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core as app;
use app\models\PgSql;

class TestPgSql extends app\Controller {

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
        $mysql = new PgSql();
        $tb = $mysql->showTableTest();
        foreach ($tb as $value) {
            echo $value . "<br>";
        }
    }

    public function column() {
        $mysql = new PgSql();
        $tb = $mysql->showColumnTest()->fetchArray();
        foreach ($tb as $value) {
            echo $value['Field']."  ".$value['Key']."<br>";
        }
    }

    public function insert() {
        $mysql = new PgSql();
        $tb = $mysql->insert();
       
    }
    
    public function update() {
        $mysql = new PgSql();
        $tb = $mysql->update();
       
    }
    
    public function delete() {
        $mysql = new PgSql();
        $tb = $mysql->delete();
       
    }
    
    public function select() {
        $mysql = new PgSql();
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
