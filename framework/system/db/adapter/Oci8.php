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
                $data[$key] = $this->escape($value);
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
        return 0;
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
        try {
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
        $offset = intval($offset);
        $stop = $offset + intval($limit);
        return
                "SELECT * FROM (SELECT a.*, rownum ar_rnum__ FROM ($sql) a " .
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
     * override
     * @param type $table
     * @param type $where
     * @return type
     */
   /* public function countAll($table, $where = null) {
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
        $result = reset($result);
        return $result['NUM_ROWS'];
    } */
}
