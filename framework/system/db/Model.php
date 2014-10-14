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
use system\helper\Paginator;

class Model {

    /**
     *
     * @var type 
     */
    private $attributes = array();

    /**
     *
     * @var type 
     */
    private $column = array();

    /**
     *
     * @var type 
     */
    private $table = '';

    /**
     *
     * @var type 
     */
    private $pk;

    /**
     *
     * @var type 
     */
    protected $db;

    /**
     *
     * @var type 
     */
    private $validator;

    /**
     *
     * @var type 
     */
    private static $instance = array();

    /**
     *
     * @var type 
     */
    private $result = array();

    /**
     * constructor
     * @param type $table
     * @param type $db
     */
    public function __construct($table = '', $db = '') {

        if ($table) {
            $this->table = $table;
        } else {
            $table = explode('\\', get_called_class());
            $this->table = end($table);
        }
        $this->db = Database::getConnection($db);
    }

    /**
     * get the instance of the inherits class
     * @return type
     */
    public static function model() {
        $class = get_called_class();
        if (!isset(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }

    /**
     * 
     * @return type
     */
    public function insertId() {
        return $this->db->insertId();
    }

    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return type
     * @throws \system\core\MainException
     */
    public function __call($name, $arguments) {
        if (method_exists($this->db, $name)) {
            return call_user_func_array(array($this->db, $name), $arguments);
        } else {
            throw new \system\core\MainException("function $name not found");
        }
    }

    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return type
     * @throws \system\core\MainException
     */
    public static function __callStatic($name, $arguments) {
        $model = self::model();
        if (method_exists($model, $name)) {
            return call_user_func_array(array($model, $name), $arguments);
        } else {
            throw new \system\core\MainException("function $name not found");
        }
    }

    /**
     * get data
     * @return type
     */
    public function find($condition = array()) {

        $this->buildCondition($condition);

        if (!isset($condition['select'])) {
            $this->db->select('*');
        }
        return $this->db->from($this->table)->One();
    }

    /**
     * find data by primary key
     * @param type $pk
     * @return type
     */
    public function findByPk($pk, $condition = array()) {
        $this->getColumn();
        $this->buildCondition($condition);
        if (!isset($condition['select'])) {
            $this->db->select('*');
        }
        $this->db->where(array($this->pk => $pk));
        return $this->db->from($this->table)->One();
    }

    public function findAll($condition = array()) {

        $this->buildCondition($condition);
        if (!isset($condition['select'])) {
            $this->db->select('*');
        }
        return $this->db->from($this->table)->All();
    }

    /*
     * 
     */

    private function buildCondition(array $condition) {
        foreach ($condition as $method => $value) {
            if (method_exists($this->db, $method)) {
                if ($method === 'param') {
                    $value = array($value);
                }
                call_user_func_array(array($this->db, $method), $value);
            }
        }
    }

    /**
     * 
     * @param type $sql
     * @param type $values
     * @return type
     */
    public function findBySql($sql, $values = array()) {
        $this->db->reset();
        return $this->db->query($sql, $values)->All();
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

        if ($this->pk == '') {
            $this->getColumn();
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
        } else {
            return '';
        }
    }

    /**
     * 
     */
    public function getColumn() {

        if ($this->pk == '') {
            $cols = $this->db->columns($this->table);
            foreach ($cols as $key => $value) {
                if ($value['pk']) {
                    $this->pk = $value['name'];
                }
                $this->column[$value['name']] = $value;
            }
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

        $this->db->update($this->table, $this->attributes, $where);
        return $this;
    }

    /**
     * 
     * @return \system\db\Model|boolean
     */
    public function save($isValidate = true) {
        if ($isValidate === true and ! $this->validate()) {
            return false;
        }
        $this->db->insert($this->table, $this->attributes);

        $this->attributes[$this->pk] = $this->db->insertId();
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function countAll($where = "") {
        return $this->db->countAll($this->table, $where);
    }

    /**
     * 
     * @param type $where
     * @return \system\db\Model
     */
    public function delete($where = null) {
        try {
            if (!isset($this->attributes[$this->pk])) {
                throw new \system\core\DbException("the value of this field {$this->pk} is null check your assigment for primary key");
            }

            if (!$where) {
                $where = array($this->pk => $this->attributes[$this->pk]);
            }
            $this->db->delete($this->table, $where);
            return $this;
        } catch (\system\core\DbException $exc) {
            echo $exc->printError();
        }
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function updateAll($data) {
        return $this->db->update($this->table, $data);
    }

    /**
     * 
     * @return type
     */
    public function first() {
        $this->getColumn();

        $result = $this->db->select()
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
        $this->getColumn();

        $result = $this->db->select()
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

    /**
     * 
     * @param type $target
     * @return type
     */
    public function paging($target, $criteria = null) {
        $current = Base::instance()->input->get('page', 1);
        $where = "";

        if (is_array($criteria)) {
            $where = isset($criteria['where'][0]) ? reset($criteria['where']) : "";
        } else {
            $where = $criteria;
        }
        $count = $this->CountAll($where);
        $paging = new Paginator($current, $count);
        $paging->setRPP(10);
        $paging->setTarget(Base::instance()->base_url . $target);
        return $paging->parse();
    }

    /**
     * get table name
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

}
