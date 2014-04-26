<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\driver;

/**
 * Description of Postgre Sql
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use system\core\DbException;
use system\db\Db;

class PgSql extends Db {

    /**
     * constructor
     * @access public
     * @param string $host database hostname
     * @param string $user database username
     * @param string $pass database password
     * @param string $dbname database name
     * @return void
     * */
    public function __construct($host, $user, $pass, $database, $persistent, $autoinit) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
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
            if (!($this->conn = pg_connect("host={$this->host} dbname={$this->database} user={$this->user} password={$this->pass}"))) {
                $message .= "<p> Message: cannot connect to the database" . pg_last_error($this->conn) . "<p>";
                throw new DbException($message);
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
            if (!($this->conn = pg_pconnect("host={$this->host} dbname={$this->database} user={$this->user} password={$this->pass}"))) {
                throw new DbException(pg_last_error());
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
        } else {
            $data = addslashes(pg_escape_string($this->conn, $data));
        }

        return $data;
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
        return pg_num_rows($this->conn);
    }

    /**
     * Insert ID
     *
     * @access	public
     * @return	integer
     */
    public function insertId() {
        return false;
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

            if (!($status = pg_query($this->conn, $sql))) {
                $message = "Query:  " . $sql;
                $message .= "<p> Message: " . pg_last_error() . "<p>";
                throw new DbException($message);
            }
        } catch (DbException $e) {
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
        while ($row = pg_fetch_assoc($this->resultid)) {
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
        while ($row = pg_fetch_object($this->resultid)) {
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
        pg_free_result($this->resultid);
    }

    public function numRows() {
        return pg_num_rows($this->resultid);
    }

    public function countAll($table) {
        if ($table == '')
            return 0;
        $this->query("SELECT COUNT(*) AS NUM_ROWS FROM {$table}");
        $result = $this->fetchArray();
        $row = reset($result);
        return $row['NUM_ROWS'];
    }

    public function insert($table, $data = array()) {
        $fields = array_keys($data);

        foreach ($data as $key => $val)
            $data[$key] = $this->escapeStr($val);

        return $this->query("INSERT INTO $table (" . implode(', ', $fields) . ") VALUES ('" . implode("','", $data) . "')");
    }

    public function delete($table, $where = array()) {

        if (is_array($where)) {

            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escapeStr($val) . "'";
            }
            $where = implode(' AND ', $wheres);
        } else {
            return false;
        }
        return $this->query("DELETE FROM $table WHERE $where");
    }

    public function limit($limit = 0, $offset = 0) {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

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

    public function select() {
        $column = func_get_args();
        if (!empty($column)) {
            $this->column = array_merge($this->column, $column);
        }
        return $this;
    }

    public function join($join) {
        $this->joins = $join;
        return $this;
    }

    public function orderBy($column, $type = 'ASC') {
        $this->order = $column;
        $this->orderType = $type;
        return $this;
    }

    public function groupBy($column) {
        $column = func_get_args();
        if (!empty($column)) {
            $this->group = array_merge($this->group, $column);
        }
        return $this;
    }

    public function distinct($val = TRUE) {
        $this->distinct = (is_bool($val)) ? $val : TRUE;
        return $this;
    }

    public function having($having) {
        $this->having = $having;
        return $this;
    }

    public function update($table, $data, $where = null) {

        $datas = array();
        $wheres = array();

        foreach ($data as $key => $val) {
            $datas[] = "$key = '{$this->escapeStr($val)}'";
        }

        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escapeStr($val) . "'";
            }
            $where = implode(' AND ', $wheres);
        }
        $this->query("UPDATE $table SET " . implode(', ', $datas) . ' WHERE ' . $where);
        return $this;
    }

    public function listTable($like = null) {
        $criteria = "";
        
        if (is_string($like)) {
            $like = $this->escapeStr($like);
           // $criteria = " AND LIKE '{$like}%'";
        }
        $this->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' {$criteria}");
        return $this;
    }

    public function listColumn($table, $like = NULL) {
        $tables = array();
        $this->query("SELECT column_name FROM information_schema.columns WHERE table_name ='$table'");
        return $this;
    }

    public function result() {
        $this->sql = "SELECT ";
        $this->sql .= (empty($this->column)) ? " * " : implode(', ', $this->column);
        $this->sql .= " FROM " . implode(', ', $this->tables);
        $this->sql .=($this->join) ? $this->join : "";
        $this->sql .= ($this->criteria) ? " WHERE " . $this->criteria : "";
        $this->sql .= (!empty($this->group)) ? " GROUP BY " . implode(', ', $this->group) : "";
        $this->sql .= (!empty($this->having)) ? " HAVING " . $this->having : "";
        $this->sql .= ($this->order) ? " ORDER BY " . $this->order . " " . $this->orderType : "";
        $this->sql .= ($this->limit) ? " LIMIT " . $this->limit : "";
        $this->sql .= ($this->offset) ? ", " . $this->offset : "";

        $this->query($this->sql);
        return $this;
    }

    public function dbClose() {
        if ($this->conn)
            pg_close($this->conn);
    }

}
