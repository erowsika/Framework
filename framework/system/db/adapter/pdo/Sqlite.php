<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\adapter\pdo;

/**
 * Description of Mysql
 *
 * @author masfu
 */
use system\db\DbAdapter;
use system\core\DbException;

class Mysql extends DbAdapter {

    protected $drivername;

    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->dsn = $config['dsn'];
        $this->autoinit = $config['autoinit'];
        $this->persistent = $config['persistent'];

        if ($this->autoinit) {
            $this->connect();
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
