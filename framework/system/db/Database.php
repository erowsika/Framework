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

namespace system\db;

use system\core\Base;
use \system\core\Config;
class Database {

    private static $_instance = null;
    private static $dbconn = array();
    private $config;

    public function __construct() {
        $this->config = Config::getInstance();
    }

    public static function getDBConnection($dbname = '') {

        if (self::$_instance === null) {
            self::$_instance = new Database();
        }
        return self::$_instance->createDb($dbname);
    }

    public function createDb($dbname = '') {
        $dbconfig = $this->config->get('database');
        $db = array();

        if ($dbname == '') {
            $db = reset($dbconfig);
        } else {
            $db = $dbconfig[$dbname];
        }

        if (!isset(self::$dbconn[$dbname])) {
            extract($db);
            switch ($driver) {
                case 'mysql':
                    self::$dbconn[$dbname] = new Mysql($host, $username, $password, $database, $port, $persistent, $autoinit);
                    break;
                case 'pgsql':
                    break;
                case 'oracle':
                    self::$dbconn[$dbname] = new Oci8($connstring, $username, $password, $port, $persistent, $autoinit);
                    break;
                case 'monggodb':
                    break;
                case 'pdo':
                    break;
                default:
                    break;
            }
        }
        return self::$dbconn[$dbname];
    }

}
