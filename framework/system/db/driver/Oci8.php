<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\driver;

/**
 * Description of Oracle
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use system\core\DbException;
use system\db\Db;

class Oci8 extends Db {

    protected $_commit = OCI_COMMIT_ON_SUCCESS;

    /**
     * constructor
     * @access public
     * @param string $host database hostname
     * @param string $user database username
     * @param string $pass database password
     * @param string $dbname database name
     * @return void
     * */
    public function __construct($connString, $user, $pass, $port, $persistent, $autoinit) {
        $this->connString = $connString;
        $this->user = $user;
        $this->pass = $pass;
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
    }

    /**
     * connect database to server based on config file
     * @access public
     * @return void     * 
     * 
     * */
    public function dbConnect() {
        try {
            if (!($this->conn = ocilogon($this->user, $this->pass, $this->connString))) {
                $e = oci_error();
                throw new DbException($e['message']);
            }
        } catch (DbException $e) {
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
            if (!($this->conn = @ociplogon($this->user, $this->pass, $this->connString))) {
                $e = oci_error();
                throw new DbException($e['message']);
            }
        } catch (DbException $e) {
            $e->printError();
        }
    }

    /**
     * escaping character
     * @param type $data
     * @return string or array 
     */
    public function escapeStr($data) {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->escapeStr($value);
            }
        }else
            $data = addslashes ($data);
        
        return $data;
    }

    public function bindParam(&$data = array()) {
        try {
            foreach ($data as $key => $value) {
                $name = ":" . $key;

                if (!oci_bind_by_name($this->stmt, $name, $data[$key])) {
                    $e = oci_error();
                    throw new DbException($e['message']);
                }
            }
        } catch (DbException $e) {
            
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
        return @oci_num_rows($this->stmt);
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
    public function _exec($sql, $data) {

        if (!$this->autoinit) {
            $this->initDb();
        }
        try {
            $this->stmt = ociparse($this->conn, $sql);
            if (!$this->stmt) {
                $e = oci_error($this->stmt);
                $str = htmlentities("error " . $e['message']);
                throw new DbException($str);
            }

            $this->bindParam($data);

            if (!($result = @oci_execute($this->stmt, $this->_commit))) {
                $e = oci_error($this->stmt);
                $str = htmlentities($e['message']);
                $str .= "<pre>";
                $str .= htmlentities($e['sqltext']) . "<br>";
                for ($i = 0; $i < $e['offset']; $i++) {
                    $str .= " ";
                }
                $str .= "^";
                $str .= "</pre>";
                throw new DbException($str);
            }
        } catch (DbException $e) {
            $e->printError();
        }
        return $result;
    }

    /**
     * execute query
     * @access public
     * @param string $name Description
     * @return type Description
     * */
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
        while ($row = @oci_fetch_assoc($this->stmt)) {
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
        while ($row = @oci_fetch_object($this->stmt)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * flush the resoutce
     * @access public
     * @return void
     */
    public function freeResult() {
        @oci_free_statement($this->stmt);
    }

    /**
     * get number rows
     * @return int
     */
    public function numRows() {
        return @oci_num_rows($this->stmt);
    }

    /**
     * get count row
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
     * insert data to table
     * @param string $table
     * @param array $data
     * @return Oci8
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
     * update table
     * @param string $table
     * @param array $data
     * @param array $where
     * @return \system\db\Oci8
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
     * delete row
     * @param string $table
     * @param string $where
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
     * limit select statment
     * @param type $limit
     * @param type $offset
     * @return \system\db\Oci8
     */
    public function limit($limit = 0, $offset = 0) {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    /**
     * 
     * @return \system\db\Oci8
     */
    public function from() {
        $table = func_get_args();
        if (!empty($table)) {
            $this->tables = array_merge($this->tables, $table);
        }
        return $this;
    }

    /**
     *  
     * @param string $where
     * @return \system\db\Oci8
     */
    public function where($where) {

        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escapeStr($val) . "'";
            }
            $this->criteria = implode(' AND ', $wheres);
        }
        if (is_string($where)) {
            $this->criteria = $where;
        }

        return $this;
    }

    /**
     * 
     * @return \system\db\Oci8
     */
    public function select() {
        $column = func_get_args();
        if (!empty($column)) {
            $this->column = array_merge($this->column, $column);
        }
        return $this;
    }

    /**
     * 
     * @param type $join
     * @return \system\db\Oci8
     */
    public function join($join) {
        $this->joins = $join;
        return $this;
    }

    /**
     * 
     * @param type $column
     * @param type $type
     * @return \system\db\Oci8
     */
    public function orderBy($column, $type = 'ASC') {
        $this->order = $column;
        $this->orderType = $type;
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return \system\db\Oci8
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
     * @param type $having
     * @return \system\db\Oci8
     */
    public function having($having) {
        $this->having = $having;
        return $this;
    }

    /**
     * 
     * @param type $val
     * @return \system\db\Oci8
     */
    public function distinct($val = TRUE) {
        $this->distinct = (is_bool($val)) ? $val : TRUE;
        return $this;
    }

    /**
     * 
     * @param type $like
     * @return \system\db\Oci8
     */
    public function listTable($like = null) {
        $criteria = "";
        if (is_string($like)) {
            $like = $this->escapeStr($like);
            $criteria = "WHERE TNAME LIKE '{$like}%'";
        }
        $this->query("SELECT * FROM TAB {$criteria}");
        return $this;
    }

    /**
     * 
     * @param type $table
     * @param type $like
     * @return \system\db\Oci8
     */
    public function listColumn($table, $like = NULL) {
        $tables = array();
        $criteria = "";

        if (is_string($like)) {
            $like = $this->escapeStr($like);
            $criteria = " LIKE '{$like}%'";
        }
        $this->query("DESC EMPLOYEES $table");
        return $this;
    }

    /**
     * 
     * @return \system\db\Oci8
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
            echo $this->limit."   ".$this->offset;
            $this->sql = "SELECT OUTER.* FROM (SELECT ROWNUM RN, inner.* FROM ({$this->sql}) inner) OUTER WHERE OUTER.RN >= 0";
            //if ($this->offset != 0) {
                $this->sql .= " AND OUTER.RN <= 10";
           // }
        }
        $this->query($this->sql);
        return $this;
    }

    /**
     * 
     */
    public function dbClose() {
        @oci_close($this->conn);
    }

}
