<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbFactory
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace db;

class DbFactory {

    private $config;

    public function __construct() {
        $this->config = new \core\Config();
    }

    public function createDb($dbname = '') {
        $dbconfig = $this->config->get('database');
        $db = array();

        if ($dbname == '') {
            $db = reset($dbname);
        } else {
            $db = $dbconfig[$dbname];
        }
        extract($db);
        
        switch ($driver) {
            case 'mysql':
                return new Mysql($host, $username, $password, $database);
                break;
            case 'pgsql':
                break;
            case '':
                break;
            default:
                break;
        }
    }

}
