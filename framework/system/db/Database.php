<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db;

/**
 * Description of SqlProvider
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use system\db\driver as driver;
use system\core\Config;
use system\core\MainException;

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
        } else if(isset($dbconfig[$dbname])){
            $db = $dbconfig[$dbname];
        }  else {
            new MainException("Database config error");
        }

        if (!isset(self::$dbconn[$dbname])) {
            extract($db);
            switch ($driver) {
                case 'mysql':
                    self::$dbconn[$dbname] = new driver\Mysql($host, $username, $password, $database, $port, $persistent, $autoinit);
                    break;
                case 'pgsql':
                    self::$dbconn[$dbname] = new driver\PgSql($host, $username, $password, $database, $persistent, $autoinit);
                    break;
                case 'oracle':
                    self::$dbconn[$dbname] = new driver\Oci8($connstring, $username, $password, $port, $persistent, $autoinit);
                    break;
                case 'monggodb':
                    self::$dbconn[$dbname] = new driver\MonggoDB($host, $username, $password, $database, $port, $autoinit);
                    break;
                case 'pdo':
                    self::$dbconn[$dbname] = new driver\PdoDb($dsn, $username, $password,  $autoinit);
                    break;
                default:
                    new MainException("Database type not supported");
                    break;
            }
        }
        return self::$dbconn[$dbname];
    }

}
