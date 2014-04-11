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

class Mysql extends Db {

    /**
     * constructor
     * @access public
     * @param string $host database hostname
     * @param string $user database username
     * @param string $pass database password
     * @param string $dbname database name
     * @return void
     * */
    public function __construct($host, $user, $pass, $dbname, $port, $autoinit) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->autoinit = $autoinit;

        if ($this->autoinit) {
            $this->initDb();
        }
    }

    private function initDb() {
        if ($this->persistent) {
            $this->dbConnect();
        } else {
            $this->dbPconnect();
        }

        $this->dbSelect();
    }

    /**
     * connect database to server based on config file
     * @access public
     * @return void     * 
     * 
     * */
    public function dbConnect() {
        try {
            $this->conn = mysql_connect($this->host, $this->user, $this->pass);
        } catch (\core\MainException $e) {
            $message = mysql_error($this->conn);
            $e->printError($message);
        }
    }

    /**
     * persistent database connection
     * @access public
     * @return void
     * 
     * */
    public function dbPconnect() {
        try {
            $this->conn = mysql_pconnect($this->host, $this->user, $this->pass);
        } catch (\core\MainException $e) {
            $message = mysql_error($this->conn);
            $e->printError($message);
        }
    }

    /**
     * select database base on config
     * @access private
     * @return boolean
     * @throws \core\MainException
     */
    private function dbSelect() {
        if (!mysql_select_db($this->dbname, $this->conn)) {
            throw new \core\MainException();
        }
        return true;
    }

    /**
     * escaping character
     * @param type $data
     * @return string or array 
     */
    public function escapeStr($data) {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->EscapeStr($value);
            }
        }

        if (function_exists('mysql_real_escape_string') AND is_resource($this->conn)) {
            $data = mysql_real_escape_string($str, $this->conn);
        } elseif (function_exists('mysql_escape_string')) {
            $data = mysql_escape_string($data);
        } else {
            $data = addslashes($data);
        }
    }

    /**
     * destructor
     * @access public
     * @return void
     */
    public function __destruct() {
        $this->dbClose();
    }

    /**
     * 
     * get number affected rows
     * @access public
     * @return int
     * 
     */
    public function affectedRows() {
        return @mysql_affected_rows($this->conn);
    }

    /**
     * Insert ID
     *
     * @access	public
     * @return	integer
     */
    public function insertId() {
        return @mysql_insert_id($this->conn);
    }

    /**
     * execute query
     * @access public
     * @param string $name Description
     * @return type Description
     * */
    public function _exec($sql) {
        if (!$this->persistent) {
            $this->initDb();
        }
        return @mysql_query($sql, $this->conn);
    }

    /**
     * execute query
     * @access public
     * @param string $name Description
     * @return type Description
     * */
    public function query($sql) {
        $this->resultid = $this->_exec($sql);
        return $this;
    }

    /**
     * get the result of query which return an associative array
     * @return array
     * */
    public function fetchArray() {
        $result = array();
        while ($row = mysql_fetch_array($this->resultid)) {
            $result[] = $row;
        }
        $this->freeResult();
        return $result;
    }

    /**
     * get the result of query which return an object array
     * @return array of object
     * */
    public function fetchObject() {
        $result = array();
        while ($row = @mysql_fetch_object($this->resultid)) {
            $result[] = $row;
        }
        $this->freeResult();
        return $result;
    }

    /**
     * flush the resoutce
     * @access public
     * @return void
     */
    public function freeResult() {
        mysql_free_result($this->resultid);
    }

    public function countAll($criteria, $criteria2) {
        
    }

    public function delete($table, $criteria) {
        
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

    public function select() {
        
    }

    public function update($data, $table, $criteria) {
        
    }

    public function dbClose() {
        @mysql_close($this->conn);
    }

}
