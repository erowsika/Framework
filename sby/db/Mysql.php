<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySql
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace db;

use core;

class Mysql extends DbAbstract {

    /**
     * constructor
     * @return void
     * */
    public function __construct($host, $user, $pass, $dbname) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->connect();
    }

    public function connect() {
        try {
            $this->conn = mysql_connect($this->host, $this->user, $this->pass);

            if (!mysql_select_db($this->dbname, $this->conn)) {
                throw new \core\MainException();
            }
        } catch (\core\MainException $e) {
            $message = mysql_error($this->conn);
            $e->printError($message);
        }
    }

    public function __destruct() {
        @mysql_close($this->conn);
    }

    public function countAll($criteria, $criteria2) {
        
    }

    public function delete($table, $criteria) {
        
    }

    public function fetchArray() {
        
    }

    public function fetchObject() {
        
    }

    public function findAll($criteria, $fill) {
        
    }

    public function findByPk($pk) {
        
    }

    public function insert($data, $table) {
        
    }

    public function lastData() {
        
    }

    public function limit($limit, $offset, $table, $criteria) {
        
    }

    public function query($query) {
        
    }

    public function select() {
        
    }

    public function update($data, $table, $criteria) {
        
    }

}
