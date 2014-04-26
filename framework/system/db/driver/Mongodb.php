<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\driver;

/**
 * Description of MonggoDB
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use system\db\Db;

class MonggoDB extends Db {

    public function __construct($host, $username, $password, $database, $port,$autoinit) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->port = $port;
        $this->autoinit = $autoinit;
    }

    private function connect() {
        $this->connString = sprintf('mongodb://%s:%d/%s', $hosts, $port, $database);
        $this->conn = new Mongo($this->connString, array('username' => $username, 'password' => $password));
    }

    public function countAll($table) {
        
    }

    public function delete($table, $criteria) {
        
    }

    public function fetchArray() {
        
    }

    public function fetchObject() {
        
    }

    public function insert($data, $table) {
        
    }

    public function query($query) {
        
    }

    public function select() {
        
    }

    public function update($data, $table, $criteria) {
        
    }

//put your code here
}
