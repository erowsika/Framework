<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db;

/**
 * Description of Relations
 *
 * @author Masfu Hisyam
 */
class Relations implements \Iterator {

    /**
     *
     * @var type 
     */
    private $db;

    /**
     *
     * @var type 
     */
    private $result;

    /**
     *
     * @var type 
     */
    private $type;

    /**
     *
     * @var type 
     */
    private $arrayResult;

    /**
     * 
     * @param \system\db\Model $model
     */
    public function __construct(Model $model) {
        $this->db = $model->getDb();
    }

    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return \system\db\Relations
     */
    public function __call($name, $arguments) {
        if (method_exists($this->db, $name)) {
            call_user_func_array(array($this->db, $name), $arguments);
        }
        return $this;
    }

    /**
     * 
     * @param type $key
     */
    public function __get($key) {
        if (empty($this->result)) {
            if (in_array($this->type, ['hasOne', 'belongsTo'])) {
                $this->result = (array) $this->db->One();
                $this->db->reset();
            }
        }
        if (isset($this->result[$key])) {
            return $this->result[$key];
        } else {
            return '';
        }
    }

    /**
     * 
     * @param type $table
     * @param type $parentKey
     * @param type $value
     * @return \system\db\Relations
     */
    public function belongsTo($table, $parentKey, $value) {
        $this->type = $this->getMethod(__METHOD__);
        $this->result = null;
        $condition = $parentKey . " = '" . $value . "'";
        $this->db->select('*')->from($table)->where($condition);
        return $this;
    }

    /**
     * 
     * @param type $table
     * @param type $column
     * @param type $value
     * @return type
     */
    public function hasOne($table, $column, $value) {
        $this->type = $this->getMethod(__METHOD__);
        $this->result = null;
        $condition = $column . " = '" . $value . "'";
        $this->db->select('*')->from($table)->where($condition);
        return $this;
    }

    /**
     * 
     * @param type $table
     * @param type $parentKey
     * @param type $value
     * @return \system\db\Relations
     */
    public function hasMany($table, $localKey, $value) {
        $this->type = $this->getMethod(__METHOD__);
        $this->result = null;
        $condition = $localKey . " = '" . $value . "'";
        $this->db->select('*')->from($table)->where($condition);
        return $this;
    }

    /**
     * 
     * @param type $table1
     * @param type $table2
     * @param type $column1
     * @param type $column2
     */
    public function belongsToMany($table1, $table2, $column1, $column2, $column3, $value) {
        $this->type = $this->getMethod(__METHOD__);
        $this->result = null;
        $condition = $column3 . " = '" . $value . "'";

        $this->db->select('t1.*')
                ->from($table1 . ' t1')
                ->join('join ' . $table2 . ' t2 on t1.' . $column1 . '=' . ' t2.' . $column2)
                ->where($condition);
        return $this;
    }

    /**
     * 
     * @param type $column
     * @param type $condition
     * @param type $value
     */
    public function where($column, $condition, $value) {
        $where = ' AND ' . $column . ' ' . $condition . "'" . $value . "'";
        $this->db->where($where);
        return $this;
    }

    /**
     * 
     */
    public function first() {
        $this->result = (array) $this->db->One();
        $this->db->reset();
        return $this;
    }

    /**
     * 
     * @param type $method
     * @return type
     */
    private function getMethod($method) {
        $arr = explode('::', $method);
        $method = end($arr);
        return $method;
    }

    /**
     * 
     */
    public function current() {
        $this->result = (array) $this->arrayResult[$this->position];
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
        if (empty($this->arrayResult)) {
            $this->arrayResult = $this->db->All();
            $this->db->reset();
        }
        return isset($this->arrayResult[$this->position]);
    }

}
