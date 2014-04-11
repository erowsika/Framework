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

namespace db;

abstract class Db {

    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $conn;
    protected $port;
    protected $persistent;
    protected $autoinit;
    protected $resultid;

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

    abstract function findByPk($pk);

    abstract function findAll($criteria, $fill);

    abstract function countAll($criteria, $criteria2);

    abstract function lastData();

    abstract function limit($limit, $offset, $table, $criteria);
}
