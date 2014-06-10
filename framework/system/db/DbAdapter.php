<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db;

/**
 *
 * @author masfu
 */
use system\core\DbException;

abstract class DbAdapter {

    protected $host;
    protected $username;
    protected $password;
    protected $database;
    protected $conn;
    protected $dsn;
    protected $port;
    protected $persistent;
    protected $autoinit;
    protected $resultid;
    protected $param = array();
    /*
     * for active record
     */
    protected $column = array();
    protected $criteria = '';
    protected $tables = array();
    protected $join = '';
    protected $distinct = FALSE;
    protected $limit = '';
    protected $offset = '';
    protected $having;
    protected $order;
    protected $orderType;
    protected $group = array();
    protected $sql = '';

    /**
     * connect database
     * @throws DbException
     */
    public function connect() {
        try {
            if (!($this->conn = new \PDO($this->dsn, $this->username, $this->password))) {
                throw new DbException("Could not connect to the database");
            }

            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->drivername = $this->conn->getAttribute(\PDO::ATTR_DRIVER_NAME);
        } catch (DbException $e) {
            echo $e->printError();
        }
    }

    /**
     * connect database with persistent connection
     * @throws DbException
     */
    public function pconnect() {
        try {

            $option = array(PDO::ATTR_PERSISTENT => true);

            if (!($this->conn = new \PDO($this->dsn, $this->username, $this->password, $option))) {
                throw new DbException("Could not connect to the database");
            }

            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->drivername = $this->conn->getAttribute(\PDO::ATTR_DRIVER_NAME);
        } catch (DbException $e) {
            echo $e->printError();
        }
    }

    public function disconnect() {
        
    }

    /**
     * initialize database according from config file
     */
    public function initialize() {
        if (!$this->persistent) {
            $this->connect();
        } else {
            $this->pconnect();
        }
    }

    /**
     * 
     * @param type $table
     */
    public function columns($table) {
        $column = array();
        $result = $this->_column($table)->fetchAssoc();

        foreach ($result as $name => $val) {
            $column[$name] = $this->_columnInfo($val);
        }
        return $column;
    }

    /**
     * get list table
     * @param string $like
     * @return array
     */
    public function tables($like = null) {
        return $this->_tables($like)->fetchAssoc();
    }

    /**
     * begin transaction
     * @throws DbException
     */
    public function transaction() {
        if (!$this->conn->beginTransaction()) {
            throw new DbException();
        }
    }

    /**
     * commit transaction
     * @throws DbException
     */
    public function commit() {
        if (!$this->conn->commit()) {
            throw new DbException();
        }
    }

    /**
     * roolback transaction
     * @throws DbException
     */
    public function rollback() {
        if (!$this->connection->rollback()) {
            throw new DbException();
        }
    }

    /**
     * insert data to database
     * @param string $table table name
     * @param array $data   data
     * @return database
     */
    public function insert($table, $data = array()) {
        $fields = array_keys($data);
        foreach ($data as $key => $val) {
            $data[$key] = $this->escape($val);
        }
        return $this->query("INSERT INTO $table (" . implode(', ', $fields) . ") VALUES ('" . implode("','", $data) . "')");
    }

    /**
     * update table
     * @param string $table
     * @param array $data
     * @param string $where
     * @return \system\db\DbAdapter
     */
    public function update($table, $data, $where = null) {

        $datas = array();
        $wheres = array();

        foreach ($data as $key => $val) {
            $datas[] = " $key = '{$this->escape($val)}'";
        }

        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escape($val) . "'";
            }
            $where = implode(' AND ', $wheres);
        }
        $this->query("UPDATE $table SET " . implode(', ', $datas) . ' WHERE ' . $where);
        return $this;
    }

    /**
     * delete data
     * @param string $table
     * @param string $where
     * @return boolean
     */
    public function delete($table, $where = array()) {

        if (is_array($where)) {

            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escape($val) . "'";
            }
            $where = implode(' AND ', $wheres);
        } else {
            return false;
        }
        return $this->query("DELETE FROM $table WHERE $where");
    }

    /**
     * limiting data
     * @param int $limit
     * @param int $offset
     * @return \system\db\DbAdapter
     */
    public function limit($limit = 0, $offset = 0) {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    /**
     * select table
     * @return \system\db\DbAdapter
     * @throws DbException
     */
    public function from() {
        $table = func_get_args();
        try {
            if (!empty($table)) {
                $this->tables = array_merge($this->tables, $table);
            } else {
                throw new DbException("please select at least one table");
            }
        } catch (DbException $e) {
            echo $e->printError();
        }
        return $this;
    }

    /**
     * add criteria
     * @param string $where
     * @return \system\db\DbAdapter
     */
    public function where($where, $data = array()) {

        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escape($val) . "'";
            }
            $this->criteria = implode(' AND ', $wheres);
        }

        if (is_string($where)) {
            $this->criteria = $where;
        }

        if (is_array($data)) {
            $this->param = array_merge($this->param, $data);
        }
        return $this;
    }

    /**
     * select data
     * @return \system\db\DbAdapter
     */
    public function select() {
        $column = func_get_args();
        if (!empty($column)) {
            $this->column = array_merge($this->column, $column);
        }
        return $this;
    }

    /**
     * join table
     * @param type $join
     * @return \system\db\DbAdapter
     */
    public function join($join) {
        $this->joins = $join;
        return $this;
    }

    /**
     * order data
     * @param string $column
     * @param string $type
     * @return \system\db\DbAdapter
     */
    public function orderBy($column, $type = 'ASC') {
        $this->order = $column;
        $this->orderType = $type;
        return $this;
    }

    /**
     * group by
     * @param string $column
     * @return \system\db\DbAdapter
     */
    public function groupBy($column) {
        $column = func_get_args();
        if (!empty($column)) {
            $this->group = array_merge($this->group, $column);
        }
        return $this;
    }

    /**
     * 
     * @param string $val
     * @return \system\db\DbAdapter
     */
    public function distinct($val = TRUE) {
        $this->distinct = (is_bool($val)) ? $val : TRUE;
        return $this;
    }

    /**
     * 
     * @param type $having
     * @return \system\db\DbAdapter
     */
    public function having($having) {
        $this->having = $having;
        return $this;
    }

    /**
     * 
     * @param type $table
     * @param type $where
     * @return type
     */
    public function countAll($table, $where = null) {
        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escape($val) . "'";
            }
            $where = implode(' AND ', $wheres);
        }

        if (!empty($where)) {
            $where = " WHERE " . $where;
        }

        $result = $this->query("SELECT COUNT(*) AS num_rows FROM $table $where")->fetchAssoc();
        return reset($result)['num_rows'];
    }

    /**
     * 
     * @return type
     */
    public function buildSelect() {

        $sql = "SELECT ";

        $sql .= (empty($this->column)) ? " * " : implode(', ', $this->column);

        $sql .= " FROM " . implode(', ', $this->tables);

        $sql .=($this->join) ? $this->join : "";

        $sql .= ($this->criteria) ? " WHERE " . $this->criteria : "";

        $sql .= (!empty($this->group)) ? " GROUP BY " . implode(', ', $this->group) : "";

        $sql .= (!empty($this->having)) ? " HAVING " . $this->having : "";

        $sql .= ($this->order) ? " ORDER BY " . $this->order . " " . $this->orderType : "";

        if ($this->limit || $this->offset) {
            $sql = $this->_limit($sql, $this->limit, $this->offset);
        }
        return $sql;
    }

    /**
     * reset database query
     */
    public function reset() {
        $this->column = array();
        $this->criteria = '';
        $this->tables = array();
        $this->join = '';
        $this->distinct = FALSE;
        $this->limit = '';
        $this->offset = '';
        $this->having;
        $this->order;
        $this->orderType;
        $this->group = array();
        $this->sql = '';
    }

    /**
     * 
     * @return \system\db\DbAdapter
     */
    public function get() {

        if (count($this->tables) > 0) {
            $this->sql = $this->buildSelect();
            $this->query($this->sql, $this->param);
        }
        return $this;
    }

    /**
     * fetch all data
     * @param type $mode
     * @return type
     */
    public function All($mode = 'Assoc') {
        return ($mode == 'Assoc') ?
                $this->get()->fetchAssoc() : $this->get()->fetchObject();
    }

    /**
     * 
     * @param type $mode
     * @return type
     */
    public function One($mode = 'Assoc') {
        $data = $this->All($mode);
        return ($data != false) ? reset($data) : false;
    }

    /**
     * 
     * @param type $sql
     * @param type $value
     * @return \system\db\DbAdapter
     * @throws DbException
     */
    public function query($sql, &$value = array()) {
        try {
            if ($this->autoinit) {
                $this->connect();
            }

            if (!($this->stmt = $this->conn->prepare($sql))) {
                $message = $this->conn->errorInfo();
                $errorCode = $this->conn->errorCode();
                throw new DbException($message, $errorCode);
            }
            $this->bindParam($value);

            if (!($this->stmt->execute($value))) {
                $message = $this->conn->errorInfo();
                $errorCode = $this->conn->errorCode();
                throw new DbException($message, $errorCode);
            }
        } catch (DbException $e) {
            $e->printError();
        }
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function fetchObject() {
        $result = array();
        while ($row = $this->stmt->fetch(\PDO::FETCH_OBJ)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * 
     * @return type
     */
    public function fetchAssoc() {
        $result = array();
        while ($row = $this->stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * 
     * @param type $str
     * @return type
     */
    public function escape($str) {

        return $this->stmt->quote($str);
    }

    /**
     * 
     * @param type $sequence
     */
    public function insertId($sequence = null) {
        $this->conn->lastInsertId($sequence);
    }

    /**
     * 
     * @param type $data
     */
    public function bindParam(&$data = array()) {
        try {
            foreach ($data as $key => $value) {
                $name = ":" . $key;

                $this->stmt->bindParam($name, $data[$key]);
            }
        } catch (DbException $e) {
            $e->printError();
        }
    }

    abstract public function _columnInfo($column);

    abstract public function _column($column);

    abstract public function setEncoding($charset);

    abstract public function _tables($like = null);

    abstract public function _limit($sql, $limit, $offset);
}
