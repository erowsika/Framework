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
use ArrayAccess;
use Iterator;
use JsonSerializable;
use system\core\Base;
use system\helper\Validator;
use system\helper\Pagination;

class Model implements ArrayAccess, Iterator, JsonSerializable {

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
    protected $table = '';

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
     *
     * @var type 
     */
    private $param = array();

    /**
     *
     * @var type 
     */
    private $where = '';

    /**
     *
     * @var type 
     */
    private $operation = '';

    /**
     *
     * @var type 
     */
    private $position = 0;

    /**
     *
     * @var type 
     */
    private $resultRelation = '';

    /**
     * 
     */
    private $relation;

    /**
     * constructor
     * @param type $table
     * @param type $db
     */
    public function __construct($table = '', $db = '') {

        if ($table) {
            $this->table = $table;
        } else if ($this->table == '') {
            $table = explode('\\', get_called_class());
            $this->table = end($table);
        }
        $this->db = Database::getConnection($db);
        $this->relation = new Relations($this);
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
            call_user_func_array(array($this->db, $name), $arguments);
        }
        return $this;
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
     * 
     * @return type
     */
    public static function all() {
        $instance = self::model();
        $instance->getColumn();
        $instance->select('*');
        $instance->from($instance->table);
        $instance->operation = 'all';
        return $instance;
    }

    /**
     * 
     * @param type $id
     * @param type $columns
     * @return type
     */
    public static function find($id, $columns = array('*')) {
        $instance = self::model();
        if (is_array($id)) {
            $instance->buildCondition($id);
        }
        $instance->getColumn();
        $columns = implode(',', $columns);
        $instance->select($columns);
        $instance->where($instance->pk, '=', $id);
        $instance->from($instance->table);
        $instance->operation = 'find';
        return $instance;
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

    /**
     * 
     * @param type $condition
     * @return type
     */
    public function findAll($condition = array()) {

        $this->buildCondition($condition);
        if (!isset($condition['select'])) {
            $this->db->select('*');
        }
        return $this->db->from($this->table)->All();
    }

    /**
     * 
     * @param type $column
     * @param type $condition
     * @param type $value
     */
    public static function where($column, $condition, $value) {
        $where = $column . ' ' . $condition . "'" . $value . "'";
        $instance = self::model();
        $instance->db->where($where);
        return $instance;
    }

    /**
     * 
     * @param type $condition
     * @param type $value
     * @return type
     */
    public static function whereRaw($condition, $value) {
        $instance = self::model();
        $instance->db->where($condition)->param($value);
        return $instance;
    }

    /*
     * 
     */

    private function buildCondition(array $condition) {
        foreach ($condition as $method => $value) {
            if (method_exists($this->db, $method)) {
                switch ($method) {
                    case 'param':
                        $this->param = $value;
                        $value = array($value);
                        break;
                    case 'where':
                        $this->where = is_array($value) ? reset($value) : $value;
                        break;
                    default:
                        break;
                }
                call_user_func_array(array($this->db, $method), $value);
            } else if ($method === 'alias') {
                $name = reset($value);
                $this->alias($name);
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
        if (in_array($this->operation, ['find', 'where'])) {
            $this->attributes = $this->first();
            $this->operation = '';
            $this->db->reset();
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } else {
            if (method_exists($this, $name)) {
                return call_user_func_array([$this, $name], []);
            }
        }
        return null;
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
     */
    public function count() {
        if ($this->operation == '') {
            $this->db->from($this->table);
        }
        $result = $this->db->select('count(*) as count')->get()->fetchObject();
        $this->db->reset();
        return reset($result)->count;
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

        $pk = $this->db->insertId();
        if (is_array($pk)) {
            foreach ($pk as $key => $value) {
                $this->attributes[$key] = $value;
            }
        } else {
            $this->attributes[$this->pk] = $pk;
        }
        return $this;
    }

    /**
     * 
     * @param type $name
     */
    public function alias($name) {
        $this->table = $name;
    }

    /**
     * 
     * @return type
     */
    public function countAll($where = "") {
        $this->db->param($this->param);
        return $this->db->countAll($this->table, $this->where);
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

    public function destroy($id) {
        if (is_array($id)) {
            $where = $id;
        } else {
            $where = [$this->pk => $id];
        }
        $this->db->delete($this->table, $where);
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
        $result = $this->db
                ->limit(0)
                ->get()
                ->fetchAssoc();
        return reset($result);
    }

    /**
     * 
     * @return \system\db\Model
     * @throws \system\core\DbException
     */
    public function firstOrFail() {
        if ($this->operation == '') {
            $this->db->from($this->table);
        }
        $result = $this->db->limit(1)->get()->fetchAssoc();
        if (count($result) == 0) {
            throw new \system\core\DbException('user not found');
        } else {
            $this->attributes = (array) reset($result);
        }
        return $this;
    }

    /**
     * 
     * @param type $count
     */
    public function take($count) {
        if ($this->operation == '') {
            $this->db->from($this->table);
        }
        $this->db->limit($count);
        return $this;
    }

    /**
     * 
     * @return \system\db\Model
     */
    public function get() {
        if ($this->operation == '') {
            $this->db->from($this->table);
        }
        $this->result = $this->db->get()->fetchAssoc();
        return $this;
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
    public function paging($target = '', $criteria = null) {
        $current = Base::instance()->input->get('page', 1);
        $where = "";

        if (is_array($criteria)) {
            $where = isset($criteria['where'][0]) ? reset($criteria['where']) : "";
        } else {
            $where = $criteria;
        }
        $count = $this->CountAll($where);
        $paging = new Pagination($count, $current);
        return $paging->render();
    }

    /**
     * get table name
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * 
     * @return type
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * 
     */
    public function jsonSerialize() {
        return json_encode($this->result);
    }

    /**
     * 
     * @param type $offset
     */
    public function offsetExists($offset) {
        return isset($this->result[$offset]);
    }

    /**
     * 
     * @param type $offset
     */
    public function offsetGet($offset) {
        return isset($this->result[$offset]) ? $this->result[$offset] : null;
    }

    /**
     * 
     * @param type $offset
     * @param type $value
     */
    public function offsetSet($offset, $value) {
        $this->result[$offset] = $value;
    }

    /**
     * 
     * @param type $offset
     */
    public function offsetUnset($offset) {
        unset($this->result[$offset]);
    }

    /**
     * 
     */
    public function current() {
        $this->attributes = (array) $this->result[$this->position];
        return $this;
    }

    /**
     * 
     */
    public function key() {
        return $this->position;
    }

    /**
     * 
     */
    public function next() {
        ++$this->position;
    }

    /**
     * 
     */
    public function rewind() {
        $this->position = 0;
    }

    /**
     * 
     */
    public function valid() {
        if (empty($this->result)) {
            $this->result = $this->db->All();
            $this->db->reset();
        }
        return isset($this->result[$this->position]);
    }

    /**
     * 
     * @param type $table
     * @param type $foreignKey
     * @param type $column
     * @return type
     */
    public function hasOne($table, $foreignKey = '', $column = '') {
        $id = $this->getPrimaryKey();
        return $this->relation->hasOne($table, $column, $id);
    }

    /**
     * 
     * @param type $table
     * @param type $localKey
     * @param type $parentKey
     * @return type
     */
    public function belongsTo($table, $localKey = '', $parentKey = '') {
        $column = $localKey === '' ? $this->pk : $localKey;
        $id = $this->getPrimaryKey($column);
        return $this->relation->belongsTo($table, $parentKey, $id);
    }

    /**
     * 
     * @param type $table
     * @param type $foreignKey
     * @param type $column
     * @return type
     */
    public function hasMany($table, $column = '') {
        $id = $this->getPrimaryKey();
        return $this->relation->hasMany($table, $column, $id);
    }

    /**
     * 
     * @param type $table
     * @param type $column
     * @return type
     */
    public function belongsToMany($table1, $table2, $column1, $column2, $column3) {
        $id = $this->getPrimaryKey();
        return $this->relation->belongsToMany($table1, $table2, $column1, $column2, $column3, $id);
    }

    /**
     * 
     */
    private function getPrimaryKey($column = '') {
        if ($this->pk == '' && $column == '') {
            $this->getColumn();
        }
        $col = $column == '' ? $this->pk : $column;
        return isset($this->attributes[$col]) ? $this->attributes[$col] : '';
    }

    /**
     * 
     * @param type $table
     * @param type $criteria
     * @param type $value
     */
    public static function has($table, $criteria = '', $value = '') {
        $instance = self::model();
        if ($criteria) {
          //  $this->$table()->where()
        }
    }
    
    /**
     * 
     */
    public static function with() {
        $args = func_get_args();
        $arr  = reset($args);
        if(is_array($arr)){
            
        }else{
            
        }
    }

}
