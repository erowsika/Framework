<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db;

/**
 * Description of Model
 *
 * @author masfu
 */
use system\core\Base;
use system\helper\Validator;

class Model {

    private $attributes = array();
    private $column = array();
    private $table = '';
    private $pk;
    protected $connection;
    private $validator;
    
    private static $instance;

    /**
     * constructor
     * @param type $table
     * @param type $db
     */
    public function __construct($table = '', $db = '') {

        $this->table = ($table) ? $table : end(explode('\\', get_called_class()));
        $this->connection = Database::getConnection($db);
        $this->getColumn();
    }

    /**
     * get the instance of the inherits class
     * @return type
     */
    public static function model() {
        if (self::$instance === null) {
            $class = get_called_class();
            self::$instance = new $class();
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments) {
        $model = self::model();
        if (method_exists($model, $name)) {
            return call_user_func_array(array($model, $name), $arguments);
        }else
        {
            throw new \system\core\MainException("function $name not found");
        }
    }

    /**
     * get data
     * @return type
     */
    public function find() {
        $this->connection->select()->from($this->table);
        return $this->connection;
    }

    /**
     * find data by primary key
     * @param type $pk
     * @return type
     */
    public function findByPk($pk) {
        return $this->connection->select()
                        ->from($this->table)
                        ->where(array($this->pk => $pk));
    }

    /**
     * 
     * @param type $sql
     * @param type $values
     * @return type
     */
    public function findBySql($sql, $values = null) {
        $this->connection->reset();
        return $this->connection->query($sql, $values);
    }

    /**
     * 
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        if ($name == 'attributes') {
            $this->attributes = $value;
        }

        if (array_key_exists($name, $this->column)) {
            $this->attributes[$name] = $value;
        }
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    public function __get($name) {
        if ($name == 'attributes') {
            return $this->attributes;
        }
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
    }

    /**
     * 
     */
    public function getColumn() {
        $cols = $this->connection->columns($this->table);
        foreach ($cols as $key => $value) {
            if ($value['pk']) {
                $this->pk = $value['name'];
            }
            $this->column[$value['name']] = $value;
        }
    }

    /**
     * 
     * @param type $where
     * @return \system\db\Model|boolean
     */
    public function update($where = null) {

        if (!is_bool($where) and $where == true) {
            if (!$this->validate()) {
                return false;
            }
        }

        if (!$where) {
            $where = array($this->pk => $this->attributes[$this->pk]);
        }

        $this->connection->update($this->table, $this->attributes, $where);
        return $this;
    }

    /**
     * 
     * @return \system\db\Model|boolean
     */
    public function save() {
        if (!$this->validate()) {
            return false;
        }

        $this->connection->insert($this->table, $this->attributes);
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function countAll() {
        return $this->connection->countAll($this->table);
    }

    /**
     * 
     * @param type $where
     * @return \system\db\Model
     */
    public function delete($where = null) {
        if (!$where) {
            $where = array($this->pk => $this->attributes[$this->pk]);
        }
        $this->connection->delete($this->table, $where);
        return $this;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function updateAll($data) {
        return $this->connection->update($this->table, $data);
    }

    /**
     * 
     * @return type
     */
    public function first() {
        $result = $this->connection->select()
                ->from($this->table)
                ->limit(0, 1)
                ->orderBy($this->pk, 'ASC')
                ->get()
                ->fetchAssoc();
        return reset($result);
    }

    /**
     * 
     * @return type
     */
    public function last() {
        $result = $this->connection->select()
                ->from($this->table)
                ->orderBy($this->pk, 'ASC')
                ->get()
                ->fetchAssoc();
        return end($result);
    }

    /**
     * 
     * @return type
     */
    private function validate() {
        $validate = new Validator($this->attributes, $this);
        $validate->addRules($this->rules());
        $result = $validate->validate();
        $error = $validate->getErrors();
        Base::instance()->session->setFlashData('error', $error);
        return $result;
    }

    /**
     * 
     */
    public function rules() {
        
    }

}
