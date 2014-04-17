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

namespace system\db;

use system\core as core;

class Mysql extends Db {

    protected $column = array();
    protected $criteria = array();
    protected $tables = array();
    protected $join;
    protected $joinType;
    protected $distinct;
    protected $limit;
    protected $offset;
    protected $having;
    protected $order;
    protected $orderType;
    protected $group = array();

    /**
     * constructor
     * @access public
     * @param string $host database hostname
     * @param string $user database username
     * @param string $pass database password
     * @param string $dbname database name
     * @return void
     * */
    public function __construct($host, $user, $pass, $database, $port, $persistent, $autoinit) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->port = $port;
        $this->autoinit = $autoinit;
        $this->persistent = $persistent;

        if ($this->autoinit) {
            $this->initDb();
        }
    }

    private function initDb() {
        if (!$this->persistent) {
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
            if (!($this->conn = @mysql_connect($this->host, $this->user, $this->pass))) {
                throw new core\DbException(mysql_error(), mysql_errno());
            }
        } catch (core\DbException $e) {
            $e->printError();
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
            if (!($this->conn = @mysql_pconnect($this->host, $this->user, $this->pass))) {
                throw new core\DbException(mysql_error(), mysql_errno());
            }
        } catch (core\DbException $e) {
            $e->printError();
        }
    }

    /**
     * select database base on config
     * @access private
     * @return boolean
     * @throws \core\DbException
     */
    private function dbSelect() {
        try {
            if (!@mysql_select_db($this->database, $this->conn)) {
                throw new core\DbException(mysql_error(), mysql_errno());
            }
        } catch (core\DbException $e) {
            $e->printError();
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

        try {

            $status = false;
            if (!$this->autoinit) {
                $this->initDb();
            }

            if (!($status = @mysql_query($sql, $this->conn))) {
                $message = "Query:  " . $sql;
                $message .= "<p> Message: " . mysql_error() . "<p>";
                throw new core\DbException($message, mysql_errno());
            }
        } catch (core\DbException $e) {
            $e->printError();
        }
        return $status;
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
        @mysql_free_result($this->resultid);
    }

    public function numRows() {
        return @mysql_num_rows($this->resultid);
    }

    public function countAll($table) {
        if ($table == '')
            return 0;
        $this->query("SELECT COUNT(*) AS NUM_ROWS FROM {$table}");
        $result = $this->fetchArray();
        $row = reset($result);
        return $row['NUM_ROWS'];
    }

    public function findAll($criteria, $fill) {
        
    }

    public function findByPk($pk) {
        
    }

    public function save() {
        
    }

    public function insert($table, $data = array()) {
        $fields = array_keys($data);

        foreach ($data as $key => $val)
            $data[$key] = $this->escapeStr($val);

        return $this->query("INSERT INTO `$table` (`" . implode('`,`', $fields) . "`) VALUES ('" . implode("','", $data) . "')");
    }

    public function delete($table, $criteria) {

        if (is_array($criteria)) {

            foreach ($criteria as $c => $v) {
                $wheres[] = "$c = '" . $this->escapeStr($v) . "'";
            }

            $criteria = implode(' AND ', $wheres);
        } else {
            return false;
        }

        return $this->query("DELETE `$table` WHERE $criteria");
    }

    public function lastData() {
        
    }

    public function limit($limit, $offset, $table, $criteria) {
        
    }

    public function from($table) {
        $this->tables = explode(', ', $table);
        return $this;
    }

    public function select($column) {
        $column = explode(', ', $column);

        if (!empty($column)) {
            $this->column = $column;
        }
        return $this;
    }

    public function join($table, $type) {
        $this->joins = $table;
        $this->joinsType = $type;
    }

    public function where() {
        
    }

    public function groupBy($column){
        $this->group = explode(',', $column);
    }
    public function distinct($val = TRUE) {
        $this->distinct = (is_bool($val)) ? $val : TRUE;
        return $this;
    }

    public function update($table, $data, $where = null) {

        $datas = array();
        $wheres = array();

        foreach ($data as $key => $val) {
            $datas[] = "`$key` = '{$this->escapeStr($val)}'";
        }

        if (is_array($where)) {

            foreach ($where as $c => $v) {
                $wheres[] = "$c = '" . $this->escapeStr($v) . "'";
            }

            $criteria = implode(' AND ', $wheres);
        } else {
            return false;
        }

        return $this->query("UPDATE `$table` SET " . implode(', ', $bits) . ' WHERE ' . $criteria);
    }

    public function dbClose() {
        @mysql_close($this->conn);
    }

}
