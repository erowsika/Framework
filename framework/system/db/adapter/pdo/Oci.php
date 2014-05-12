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

class Oci extends DbAdapter {

    protected $_commit = OCI_COMMIT_ON_SUCCESS;

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
            $this->initialize();
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
        $colomnInfo = array('name' => $column['COLUMN_NAME'],
            'nullable' => ($column['NULLABLE'] === 'Y' ? true : false),
            'pk' => ($column['PK'] === 'P' ? true : false),
            'auto_increment' => false);

        return $colomnInfo;
    }

    public function fetchAssoc() {
        $result = array();
        while ($row = $this->stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = array_change_key_case($row, CASE_LOWER);
        }
        return $result;
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

}
