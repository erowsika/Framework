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

class Oci8 extends DbAdapter implements Connection {

    protected $_commit = OCI_COMMIT_ON_SUCCESS;
    protected $isTransaction = false;

    /**
     *
     * @var type 
     */
    private $lastInsertId;

    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->dsn = $config['dsn'];
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
            if (!($this->conn = ocilogon($this->username, $this->password, $this->dsn))) {
                $e = oci_error();
                throw new DbException($e['message']);
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
        return true;
    }

    /**
     * 
     */
    public function disconnect() {
        @oci_close($this->conn);
    }

    /**
     * 
     * @throws DbException
     */
    public function pconnect() {
        try {
            if (!($this->conn = @ociplogon($this->username, $this->password, $this->dsn))) {
                $e = oci_error();
                throw new DbException($e['message']);
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
        $this->query("SELECT table_name FROM user_tables {$criteria}");
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return \system\db\adapter\Mysql
     */
    public function _column($column) {
        $column = strtoupper($column);
        $sql = "SELECT c.column_name, c.data_type, c.data_length, c.data_scale, c.data_default, c.nullable, " .
                "(SELECT a.constraint_type " .
                "FROM all_constraints a, all_cons_columns b " .
                "WHERE a.constraint_type='P' " .
                "AND a.constraint_name=b.constraint_name " .
                "AND a.table_name = t.table_name AND b.column_name=c.column_name) AS pk " .
                "FROM user_tables t " .
                "INNER JOIN user_tab_columns c on(t.table_name=c.table_name) " .
                "WHERE t.table_name= '$column' ";

        $this->query($sql);
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return type
     */
    public function _columnInfo($column) {
        $colomnInfo = array('name' => strtolower($column['column_name']),
            'nullable' => ($column['nullable'] === 'Y' ? true : false),
            'pk' => ($column['pk'] === 'P' ? true : false),
            'auto_increment' => false);

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
        $str = addslashes($str);
        return $str;
    }

    /**
     * 
     * @return type
     */
    public function fetchAssoc() {
        $result = array();
        while ($row = @oci_fetch_assoc($this->stmt)) {
            $result[] = array_change_key_case($row, CASE_LOWER);
        }
        return $result;
    }

    /**
     * 
     * @return type
     */
    public function fetchObject() {
        $result = array();
        while ($row = @oci_fetch_assoc($this->stmt)) {
            $result[] = (object) array_change_key_case($row, CASE_LOWER);
        }
        return $result;
    }

    /**
     * 
     * @return type
     */
    public function insertId($sequence = null) {
        return $this->lastInsertId;
    }

    /**
     * 
     * @param type $data
     * @throws DbException
     */
    public function bindParam(&$data = array()) {
        
        try {
            foreach ($data as $key => $value) {
                $name = ":" . $key;
                if (!oci_bind_by_name($this->stmt, $name, $data[$key])) {
                    $e = oci_error();
                    echo $name . '<br>';
                    throw new DbException($e['message']);
                }
            }
        } catch (DbException $e) {
            
        }
    }

    /**
     * 
     * @param type $sql
     * @param type $value
     * @return \system\db\adapter\Mysql
     * @throws DbException
     */
    public function query($sql, &$value = array()) {
        if (!$this->isTransaction) {
            try {
                $this->execute($sql, $value);
            } catch (DbException $e) {
                $e->printError();
            }
        } else {
            $this->execute($sql, $value);
        }

        return $this;
    }

    private function execute($sql, &$value = array()) {
        if (!$this->autoinit) {
            $this->initialize();
        }

        $this->stmt = ociparse($this->conn, $sql);
        if (!$this->stmt) {
            $e = oci_error($this->stmt);
            $str = htmlentities("error " . $e['message']);
            throw new DbException($str);
        }

        $this->bindParam($value);

        if (!($result = oci_execute($this->stmt, $this->_commit))) {
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
    }

    /**
     * 
     * @return boolean
     */
    public function rollback() {
        if ($this->conn != null) {
            oci_rollback($this->conn);
        }
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function transaction() {
        $this->_commit = OCI_NO_AUTO_COMMIT;
        $this->isTransaction = true;
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function commit() {
        oci_commit($this->conn);
        $this->isTransaction = false;
        $this->_commit = OCI_COMMIT_ON_SUCCESS;
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
        $offset = intval($offset);
        $stop = $offset + intval($limit);
        return "SELECT * FROM (SELECT a.*, rownum ar_rnum__ FROM ($sql) a " .
                "WHERE rownum <= $stop) WHERE ar_rnum__ > $offset";
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

    /**
     * override method update
     * @param type $table
     * @param type $data
     * @param type $where
     * @return \system\db\adapter\Oci8
     */
    public function update($table, $data, $where = null) {

        $datas = array();
        $wheres = array();

        foreach ($data as $key => $val) {
            $datas[] = " $key = :$key";
        }

        if (is_array($where)) {
            foreach ($where as $col => $val) {
                $wheres[] = "$col = '" . $this->escape($val) . "'";
            }
            $where = implode(' AND ', $wheres);
        }
        $this->query("UPDATE $table SET " . implode(', ', $datas) . ' WHERE ' . $where, $data);
        return $this;
    }

    /**
     * override method insert to customize and get last insert id
     * @param type $table
     * @param type $data
     * @return type
     */
    public function insert($table, $data = array()) {
        $primary_key = array();
        $fields = array_keys($data);
        $colBind = array();
        $returning = '';
        foreach ($data as $key => $val) {
            $data[$key] = $this->escape($val);
            $colBind[] = ':' . $key;
        }

        $cols = $this->columns($table);
        foreach ($cols as $key => $value) {
            if ($value['pk']) {
                $pk_name = $value['name'];

                if (!isset($data[$pk_name]) || $data[$pk_name] == '') {
                    $data[$pk_name] = 999999;
                }
                $primary_key[$key] = $pk_name;
            }
        }

        if (count($primary_key) > 0) {
            $returning = "RETURNING " . implode(", ", $primary_key) . " INTO :" . implode(", :", $primary_key) . "";
        }

        $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(", ", $colBind) . ") $returning";
        $this->query($sql, $data);
        
        if (count($primary_key) > 1) {
            $this->lastInsertId = array();
            foreach ($primary_key as $key => $value) {
                $this->lastInsertId[$value] = isset($data[$value]) ? $data[$value] : 0;
            }
        } else {
            $primary_key = reset($primary_key);
            $this->lastInsertId = isset($data[$primary_key]) ? $data[$primary_key] : 0;
        }
        return true;
    }

}
