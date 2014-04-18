<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of abstract BaseDB
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\db;

abstract class Db {

    protected $host;
    protected $user;
    protected $pass;
    protected $database;
    protected $conn;
    protected $connString;
    protected $port;
    protected $persistent;
    protected $autoinit;
    protected $resultid;
    /*
     * for active record
     */
    protected $column = array();
    protected $criteria = '';
    protected $tables = array();
    protected $join;
    protected $joinType;
    protected $distinct = FALSE;
    protected $limit = '';
    protected $offset = '';
    protected $having;
    protected $order;
    protected $orderType;
    protected $group = array();

    /**
     * 
     * for oracle db
     * */
    protected $stmt;

    abstract function query($query);

    abstract function fetchArray();

    abstract function fetchObject();

    abstract function insert($data, $table);

    abstract function update($data, $table, $criteria);

    abstract function delete($table, $criteria);

    abstract function select();

    abstract function countAll($table);
}
