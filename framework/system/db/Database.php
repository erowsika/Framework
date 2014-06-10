<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db;

/**
 * Description of Database
 *
 * @author masfu
 */
use system\db\driver as driver;
use system\core\Config;
use system\core\MainException;

class Database {

    
    /**
     *
     * @var database 
     */
    private static $connections = array();

    
    /**
     * get connection
     * @param string $name
     * @return string
     */
    public static function getConnection($name = null) {
        $config = Config::getInstance()->get('database');

        if ($name == null) {
            $config = reset($config);
        } else if (isset($config[$name])) {
            $config = $config[$name];
        } else
            new MainException("Database config error");

        if (!isset(self::$connections[$name])) {
            if ($config['driver'] == 'pdo') {
                $dsn = $config['dsn'];
                $dbadapter = 'pdo\\' . ucwords(reset(explode(':', $dsn)));
            } else {
                $dbadapter = ucwords($config['driver']);
            }
            $class = 'system\\db\\adapter\\' . $dbadapter;
            self::$connections[$name] = new $class($config);
        }

        return self::$connections[$name];
    }

}
