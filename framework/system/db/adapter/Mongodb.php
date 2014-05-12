<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db\adapter;

/**
 * Description of Mongo
 *
 * @author masfu
 */
use Mongo;
use MongoException;
use system\core\DbException;

class Mongodb {

    private $connection;
    private $config;
    private $document;
    private $collection;
    protected $limit;
    protected $offset;
    protected $order;

    /**
     * 
     * @param type $config
     * @throws DbException
     */
    public function __construct($config = array()) {

        if (!class_exists('Mongo'))
            throw new DbException('Mongo PECL extension that required by Mongodb Driver is not available.');

        $this->config = $config;
        if ($this->config['autoinit']) {
            $this->initialize();
        }
    }

    /**
     * 
     */
    
    public function initialize() {

        $this->connection = new Mongo($this->config['host']);
        $this->selectDB($this->config['document']);
    }

    /**
     * 
     * @param type $db
     */
    public function selectDB($db) {
        $this->document = $this->connection->selectDB($db);
    }

    /**
     * 
     * @param type $name
     * @param type $option
     */
    public function createCollection($name, $option = array()) {
        $this->document->createCollection($name, $option);
    }

    /**
     * 
     * @param type $db
     */
    public function collection($db) {
        $this->collection = $this->document->selectCollection($db);
    }

    /**
     * 
     * @return type
     */
    public function listCollections() {
        return $this->document->listCollections();
    }

    /**
     * 
     * @param type $data
     * @param type $options
     */
    public function insert($data, $options = array()) {
        $this->collection->insert($data, $options);
    }

    /**
     * 
     * @param type $criteria
     * @param type $new_object
     * @param type $options
     */
    public function update($criteria, $new_object, $options = array()) {
        $this->collection->update($criteria, $new_object, $options);
    }

    /**
     * 
     * @param type $criteria
     * @param type $options
     */
    public function delete($criteria, $options = array()) {
        $this->collection->remove($criteria, $options);
    }

    /**
     * 
     * @param type $query
     * @param type $fields
     * @return type
     */
    public function find($query = array(), $fields = array()) {
        return $this->collection->find($query, $fields);
    }

    /**
     * 
     * @param type $query
     * @param type $fields
     * @return type
     */
    public function findOne($query = array(), $fields = array()) {
        return $this->collection->findOne($query, $fields);
    }

    /**
     * 
     * @param type $a
     * @param type $options
     */
    public function save($a, $options) {
        $this->collection->save($a, $options);
    }

}
