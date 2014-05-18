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

class Pgsql extends DbAdapter {

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
     * @param type $sql
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function _limit($sql, $limit, $offset) {
        $sql .= ' LIMIT ' . intval($limit) . ' OFFSET ' . intval($offset);
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
