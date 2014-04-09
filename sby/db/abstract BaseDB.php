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
abstract class BaseDB {
    
    protected $host;
    protected $user;
    protected $pass;
    protected $database;
    /**
     * 
     * for oracle db
     **/
    protected $stmt;
    
    abstract function insert();
    abstract function update();
    abstract function delete();
    abstract function select();
    abstract function findByPk($pk);
    abstract function findAll($where='',$fill='');
    abstract function countAll($where='', $where2='');
    
}
