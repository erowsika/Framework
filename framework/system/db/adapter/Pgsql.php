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

class Pgsql extends DbAdapter implements Connection {

    static $DEFAULT_PORT = 5432;

    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {
        $this->host = $config['host'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->database = $config['database'];
        $this->port = isset($config['port']) ? $config['port'] : self::$DEFAULT_PORT;
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
    }

    /**
     * 
     * @throws DbException
     */
    public function connect() {
        try {
            if (!($this->conn = pg_connect("host={$this->host} dbname={$this->database} user={$this->username} password={$this->password}"))) {
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

        return true;
    }

    /**
     * 
     */
    public function disconnect() {
        pg_close($this->conn);
    }

    /**
     * 
     * @throws DbException
     */
    public function pconnect() {
        try {
            if (!($this->conn = pg_pconnect("host={$this->host} dbname={$this->database} user={$this->username} password={$this->password}"))) {
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
        $this->query("SELECT tablename FROM pg_tables WHERE schemaname NOT IN('information_schema','pg_catalog') {$criteria}");
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return \system\db\adapter\Mysql
     */
    public function _column($column) {
        $this->query("SELECT
      a.attname AS field,
      a.attlen,
      REPLACE(pg_catalog.format_type(a.atttypid, a.atttypmod), 'character varying', 'varchar') AS type,
      a.attnotnull AS not_nullable,
      (SELECT 't'
        FROM pg_index
        WHERE c.oid = pg_index.indrelid
        AND a.attnum = ANY (pg_index.indkey)
        AND pg_index.indisprimary = 't'
      ) IS NOT NULL AS pk,      
      REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE((SELECT pg_attrdef.adsrc
        FROM pg_attrdef
        WHERE c.oid = pg_attrdef.adrelid
        AND pg_attrdef.adnum=a.attnum
      ),'::[a-z_ ]+',''),'''$',''),'^''','') AS default
FROM pg_attribute a, pg_class c, pg_type t
WHERE c.relname = '$column'
      AND a.attnum > 0
      AND a.attrelid = c.oid
      AND a.atttypid = t.oid
ORDER BY a.attnum");
        return $this;
    }

    /**
     * 
     * @param type $column
     * @return type
     */
    public function _columnInfo($column) {
        $colomnInfo = array('name' => $column['field'],
            'nullable' => ($column['not_nullable'] ? true : false),
            'pk' => ($column['pk'] ? true : false),
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
        } else {
            $str = addslashes(pg_escape_string($this->conn, $str));
        }
        return $str;
    }

    /**
     * 
     * @return type
     */
    public function fetchAssoc() {
        $result = array();
        while ($row = pg_fetch_assoc($this->resultid)) {
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
        while ($row = pg_fetch_object($this->resultid)) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * 
     * @return type
     */
    public function insertId() {
        return false;
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

            if (!($this->resultid = pg_query($this->conn, $sql))) {
                $message = "Query:  " . $sql;
                $message .= "<p> Message: " . pg_last_error() . "<p>";
                throw new DbException($message);
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
        return @pg_exec($this->conn, "rollback");
    }

    /**
     * 
     * @return boolean
     */
    public function transaction() {
        return @pg_exec($this->conn, "begin");
    }

    /**
     * 
     * @return boolean
     */
    public function commit() {
        return @pg_exec($this->conn, "commit");
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
        $sql .= ($limit) ? " LIMIT " . $this->limit : "";
        $sql .= ($offset) ? ", " . $this->offset : "";
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
