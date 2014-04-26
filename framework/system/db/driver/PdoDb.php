<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\driver;

/**
 * Description of PdoDB
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use system\core\DbException;
use system\db\Db;
use \PDO;

class PdoDb extends Db {

    /**
     * get the name of the database type
     * @var string 
     */
    private $drivername;

    /**
     * contructor
     * @param string $dsn
     * @param string $user
     * @param string $pass
     * @param boolean $autoinit
     */
    public function __construct($dsn, $user, $pass, $autoinit) {
        $this->connString = $dsn;
        $this->user = $user;
        $this->pass = $pass;
        $this->autoinit = $autoinit;
        if ($this->autoinit)
            $this->connect();
    }

    
    /**
     * connect to database
     * @return void
     */
    public function connect() {
        try {
            $this->conn = new PDO($this->connString, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->drivername = $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
        } catch (DbException $e) {
            echo $e->printError();
        }
    }

    /**
     * bind parameter to database
     * @param array $data
     */
    public function bindParam(&$data = array()) {
        try {
            foreach ($data as $key => $value) {
                $name = ":" . $key;

                $this->stmt->bindParam($name, $data[$key]);
            }
        } catch (DbException $e) {
            
        }
    }

    
    /**
     * execute database
     * @param string $sql
     * @param array $data
     * @return boolean
     */
    public function _exec($sql, $data) {
        try {
            if ($this->autoinit) {
                $this->connect();
            }
            $this->stmt = $this->conn->prepare($sql);
            $this->bindParam($data);
            $result = $this->stmt->execute($data);
        } catch (DbException $e) {
            $e->printError();
        }
        return $result;
    }

    
    /**
     * pass sql statment
     * @param string $sql
     * @param array $data
     * @return \system\db\driver\PdoDb
     */
    public function query($sql, $data = array()) {
        $this->_exec($sql, $data);
        return $this;
    }

    /**
     * get the result of query which return an associative array
     * @return array
     * */
    public function fetchArray() {
        $result = array();
        while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * get the result of query which return an object array
     * @return array of object
     * */
    public function fetchObject() {
        $result = array();
        while ($row = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * manual escaping data
     * @param array $data
     * @return string
     */
    public function escapeStr($data) {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->escapeStr($value);
            }
        } else
            $data = addslashes($data);

        return $data;
    }

    /**
     * count all rows
     * @param string $table
     * @return int
     */
    public function countAll($table) {
        if ($table == '')
            return 0;
        $this->query("SELECT COUNT(*) AS NUM_ROWS FROM {$table}");
        $result = $this->fetchArray();
        $row = reset($result);
        return $row['NUM_ROWS'];
    }

    /**
     * delete rows
     * @param string $table
     * @param array $where
     * @return boolean
     */
    public function delete($table, $where = array()) {
        if (is_array($where)) {

            foreach ($where as $col => $val) {
                $where[$col] = $this->escapeStr($val);
                $wheres[] = "$col = :$col";
            }
            $criteria = implode(' AND ', $wheres);
        } else {
            return false;
        }
        return $this->query("DELETE FROM $table WHERE $criteria", $where);
    }

    /**
     * insert data to table
     * @param string $table
     * @param array $data
     * @return true
     */
    public function insert($table, $data = array()) {
        $fields = array_keys($data);
        $bind = array();

        foreach ($data as $key => $val) {
            $data[$key] = $this->escapeStr($val);
            $bind[] = ':' . $key;
        }

        return $this->query("INSERT INTO $table (" . implode(',', $fields) . ") VALUES (" . implode(',', $bind) . ")", $data);
    }

    /**
     * limit number of rows
     * @param int $limit
     * @param int $offset
     * @return \system\db\driver\PdoDb
     */
    public function limit($limit = 0, $offset = 0) {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    /**
     * select column
     * @return \system\db\driver\PdoDb
     */
    public function select() {
        $column = func_get_args();
        if (!empty($column)) {
            $this->column = array_merge($this->column, $column);
        }
        return $this;
    }

    /**
     * select table
     * @return \system\db\driver\PdoDb
     */
    public function from() {
        $table = func_get_args();
        if (!empty($table)) {
            $this->tables = array_merge($this->tables, $table);
        }
        return $this;
    }

    /**
     * join table
     * @param string $join
     * @return \system\db\driver\PdoDb
     */
    public function join($join) {
        $this->joins = $join;
        return $this;
    }

    /**
     * order by
     * @param string $column
     * @param string $type
     * @return \system\db\driver\PdoDb
     */
    public function orderBy($column, $type = 'ASC') {
        $this->order = $column;
        $this->orderType = $type;
        return $this;
    }

    /**
     * group by column
     * @param string $column
     * @return \system\db\driver\PdoDb
     */
    public function groupBy($column) {
        $column = func_get_args();
        if (!empty($column)) {
            $this->group = array_merge($this->group, $column);
        }
        return $this;
    }

    /**
     * having 
     * @param string $having
     * @return \system\db\driver\PdoDb
     */
    public function having($having) {
        $this->having = $having;
        return $this;
    }

    /**
     * distinct column
     * @param boolean $val
     * @return \system\db\driver\PdoDb
     */
    public function distinct($val = TRUE) {
        $this->distinct = (is_bool($val)) ? $val : TRUE;
        return $this;
    }

    /**
     * update column
     * @param string $table
     * @param array $data
     * @param string $where
     * @return boolean
     */
    public function update($table, $data, $where = null) {
        $wheres = array();
        $bind_data = array();
        foreach ($data as $key => $val) {
            $data[$key] = $this->escapeStr($val);
            $bind_data[] = "$key = :$key";
        }

        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $data[$col] = $this->escapeStr($val);
                $wheres[] = "$col = :$col";
            }
            $where = implode(' AND ', $wheres);
        }
        return $this->query("UPDATE $table SET " . implode(', ', $bind_data) . ' WHERE ' . $where, $data);
    }

    /**
     * result and run sql
     * @return \system\db\driver\PdoDb
     */
    public function result() {
        $this->sql = "SELECT ";
        $this->sql .= (empty($this->column)) ? " * " : implode(', ', $this->column);
        $this->sql .= " FROM " . implode(', ', $this->tables);
        $this->sql .=($this->join) ? $this->join : "";
        $this->sql .= ($this->criteria) ? " WHERE " . $this->criteria : "";
        $this->sql .= (!empty($this->group)) ? " GROUP BY " . implode(', ', $this->group) : "";
        $this->sql .= ($this->having) ? " HAVING " . $this->having : "";
        $this->sql .= ($this->order) ? " ORDER BY " . $this->order . " " . $this->orderType : "";

        if ($this->limit) {
            if ($this->drivername == 'oci') {
                $this->sql = "SELECT OUTER.* FROM (SELECT ROWNUM RN, inner.* FROM ({$this->sql}) inner) OUTER WHERE OUTER.RN >= $this->limit";
                $this->sql .= " AND OUTER.RN <= $this->offset";
            } else {
                $this->sql .= " LIMIT " . $this->limit;
                $this->sql .= ($this->offset) ? ", " . $this->offset : "";
            }
        }
        $this->query($this->sql);
        return $this;
    }

//put your code here
}
