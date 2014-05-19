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

class Mysqli extends DbAdapter implements Connection {

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
            if (!($this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database))) {
                throw new DbException($conn->connect_error);
            }
        } catch (DbException $e) {
            echo $e->printError();
        }
    }

    /**
     * 
     */
    public function disconnect() {
        $this->conn->close();
    }

    /**
     * 
     * @throws DbException
     */
    public function pconnect() {
        try {
            if (!($this->conn = @mysqli_pconnect($this->host, $this->username, $this->password))) {
                throw new DbException(mysqli_error(), mysqli_errno());
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
                $str[$key] = $this->escape($value);
            }
        }
        $this->conn->real_escape_string($str);
        return $str;
    }

    /**
     * 
     * @return type
     */
    public function fetchAssoc() {
        $parameters = array();
        $results = array();

        $meta = $this->stmt->result_metadata();

        $row = array();
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $parameters[] = & $row[$field->name];
        }

        call_user_func_array(array($this->stmt, 'bind_result'), $parameters);

        while ($this->stmt->fetch()) {
            $result = array();
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
            array_push($results, $result);
        }
        return $results;
    }

    /**
     * 
     * @return type
     */
    public function fetchObject() {
        $parameters = array();
        $results = array();

        $meta = $this->stmt->result_metadata();

        $row = array();
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $parameters[] = & $row[$field->name];
        }

        call_user_func_array(array($this->stmt, 'bind_result'), $parameters);

        while ($this->stmt->fetch()) {
            $result = new \stdClass();
            foreach ($row as $key => $val) {
                $result->{$key} =(object) $val;
            }
            array_push($results, $result);
        }
        return $results;
    }

    /**
     * 
     * @param type $data
     */
    public function bindParam(&$data = array()) {
        if (is_array($data) and count($data) > 0) {
            $params = array('');
            $type = array('NULL' => '', 'string' => 's', 'integer' => 'i', 'blob' => 'b', 'double' => 'd');
            foreach ($data as $prop => $val) {
                $params[0] .= $type[gettype($val)];
                array_push($params, $data[$prop]);
            }
            $refs = array();
            foreach ($params as $key => $value) {
                $refs[$key] = & $params[$key];
            }
            call_user_func_array(array($this->stmt, 'bind_param'), $refs);
        }
    }

    /**
     * 
     * @return type
     */
    public function insertId() {
        return $this->conn->insert_id;
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
            if ($this->autoinit) {
                $this->connect();
            }

            if (!($this->stmt = $this->conn->prepare($sql))) {
                $message = "Query:  " . $sql;
                $message .= "<p> Message: " . $this->conn->error . "<p>";
                throw new DbException($message, $this->conn->errno);
            }
            $this->bindParam($value);

            if (!($this->stmt->execute())) {
                $message = $this->conn->error;
                $errorCode = $this->conn->errno;
                throw new DbException($message, $errorCode);
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

    public function dbSelect() {
        
    }

}
