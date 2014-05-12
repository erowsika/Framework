<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\adapter;

/**
 * Description of Mysql
 *
 * @author masfu
 */
use system\db\DbAdapter;
use system\db\Connection;
use system\core\DbException;

class Mysql extends DbAdapter implements Connection {

    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {
        $this->host = $config['host'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->database = $config['database'];
        $this->port = $config['port'];
        $this->autoinit = $config['autoinit'];
        $this->persistent = $config['persistent'];

        if ($this->autoinit) {
            $this->initialize();
        }
    }

    /**
     * 
     */
    public function initialize() {
        if (!$this->persistent) {
            $this->connect();
        } else {
            $this->pconnect();
        }
        $this->dbSelect();
    }

    /**
     * 
     * @throws DbException
     */
    public function connect() {
        try {
            if (!($this->conn = @mysql_connect($this->host, $this->username, $this->password))) {
                throw new DbException(mysql_error(), mysql_errno());
            }
        } catch (DbException $e) {
            $e->printError();
        }
    }

    /**
     * 
     * @return boolean
     * @throws DbException
     */
    public function dbSelect() {
        try {
            if (!@mysql_select_db($this->database, $this->conn)) {
                throw new DbException(mysql_error(), mysql_errno());
            }
        } catch (DbException $e) {
            $e->printError();
        }
        return true;
    }

    /**
     * 
     */
    public function disconnect() {
        @mysql_close($this->conn);
    }

    /**
     * 
     * @throws DbException
     */
    public function pconnect() {
        try {
            if (!($this->conn = @mysql_pconnect($this->host, $this->username, $this->password))) {
                throw new DbException(mysql_error(), mysql_errno());
            }
        } catch (DbException $e) {
            $e->printError();
        }
    }

    /**
     * 
     * @param type $like
     * @return \system\db\adapter\Mysql
     */
    public function _tables($like = null) {
        $criteria = "";

        if (is_string($like)) {
            $like = $this->escape($like);
            $criteria = " LIKE '{$like}%'";
        }
        $this->query("SHOW TABLES {$criteria}");
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return \system\db\adapter\Mysql
     */
    public function _column($column) {
        $this->query("SHOW FULL COLUMNS FROM $column");
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return type
     */
    public function _columnInfo($column) {
        $colomnInfo = array('name' => $column['Field'],
            'nullable' => ($column['Null'] === 'YES' ? true : false),
            'pk' => ($column['Key'] === 'PRI' ? true : false),
            'auto_increment' => ($column['Extra'] === 'auto_increment' ? true : false));

        return $colomnInfo;
    }

    /**
     * 
     * @param type $str
     * @return type
     */
    public function escape($str) {
        if (is_array($str)) {
            foreach ($str as $key => $value) {
                $data[$key] = $this->escape($value);
            }
        }

        if (function_exists('mysql_real_escape_string') AND is_resource($this->conn)) {
            $str = mysql_real_escape_string($str, $this->conn);
        } elseif (function_exists('mysql_escape_string')) {
            $str = mysql_escape_string($data);
        } else {
            $str = addslashes($data);
        }
        return $str;
    }

    /**
     * 
     * @return type
     */
    public function fetchAssoc() {
        $result = array();
        while ($row = mysql_fetch_assoc($this->resultid)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * 
     * @return type
     */
    public function fetchObject() {
        $result = array();
        while ($row = mysql_fetch_object($this->resultid)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * 
     * @return type
     */
    public function insertId() {
        return @mysql_insert_id($this->conn);
    }

    /**
     * 
     * @param type $sql
     * @param type $value
     * @return \system\db\adapter\Mysql
     * @throws DbException
     */
    public function query($sql, &$value = array()) {
        try {
            if (!$this->autoinit) {
                $this->initialize();
            }

            if (!($this->resultid = @mysql_query($sql, $this->conn))) {
                $message = "Query:  " . $sql;
                $message .= "<p> Message: " . mysql_error() . "<p>";
                throw new DbException($message, mysql_errno());
            }
        } catch (DbException $e) {
            $e->printError();
        }
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function rollback() {
        $this->query('ROLLBACK');
        $this->query('SET AUTOCOMMIT=1');
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function transaction() {
        $this->query('SET AUTOCOMMIT=0');
        $this->query('START TRANSACTION');
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function commit() {
        $this->query('COMMIT');
        $this->query('SET AUTOCOMMIT=1');
        return true;
    }

    /**
     * 
     * @param type $sql
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function _limit($sql, $limit, $offset) {
        $sql .= " LIMIT " . $limit;
        $sql .= ($offset) ? ", " . $offset : "";
        return $sql;
    }

    /**
     * 
     * @param type $charset
     * @return \system\db\adapter\Mysql
     */
    public function setEncoding($charset) {
        $this->query("SET NAMES $charset");
        return $this;
    }

}
