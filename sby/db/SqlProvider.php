<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SqlProvider
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace db;

class SqlProvider {

    private static $_instance = null;
    public $dbfactory;
    private $databases = array();

    public function __construct() {
        $this->dbfactory = new DbFactory();
    }

    public static function getDBConnection($dbname = '') {

        if (self::$_instance === null) {
            self::$_instance = new SqlProvider();
        }
        self::$_instance->setDatabases($dbname);
        return self::$_instance->$dbname;
    }

    public function setDatabases($dbname) {
        if (!isset($this->$dbname)) {
            $this->$dbname = $this->dbfactory->createDb($dbname);
        }
    }

}
