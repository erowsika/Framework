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

abstract class Model {

    private $attributes = array();
    private $column = array();
    private $table = '';
    private $pk;
    private $connection;
    private $validator;

    public function __construct($table = '', $db = '') {

        $this->table = ($table) ? $table : end(explode('\\', get_called_class()));
        $this->connection = Database::getConnection($db);
        $this->getColumn();
    }

    public function find($criteria) {
        $this->connection->select()->from($this->table);

        if (isset($criteria['where'])) {
            $this->connection->where($criteria['where']);
        }

        if (isset($criteria['limit'])) {
            $offset = (isset($criteria['offset']) ? $criteria['offset'] : '');
            $this->connection->limit($criteria['limit'], $offset);
        }
        return $this->connection->get()->fetchAssoc();
    }

    public function findByPk($pk) {
        $result = $this->connection->select()
                ->from($this->table)
                ->where(array($this->pk => $pk))
                ->get()
                ->fetchAssoc();
        return $result;
    }

    public function findBySql($sql, $values = null) {
        return $this->connection->query($sql, $values)
                        ->fetchAssoc();
    }

    public function __set($name, $value) {
        if ($name == 'attributes') {
            $this->attributes = $value;
        }

        if (array_key_exists($name, $this->column)) {
            $this->attributes[$name] = $value;
        }
    }

    public function __get($name) {
        if ($name == 'attributes') {
            return $this->attributes;
        }
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
    }

    public function getColumn() {
        $cols = $this->connection->columns($this->table);
        foreach ($cols as $key => $value) {
            if ($value['pk']) {
                $this->pk = $value['name'];
            }
            $this->column[$value['name']] = $value;
        }
    }

    public function update($where = null) {

        if (!$this->validate()) {
            return false;
        }
        if (!$where) {
            $where = array($this->pk => $this->attributes[$this->pk]);
        }
        $this->connection->update($this->table, $this->attributes, $where);
        return $this;
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }

        $this->connection->insert($this->table, $this->attributes);
        return $this;
    }

    public function countAll() {
        return $this->connection->countAll($this->table);
    }

    public function delete($where = null) {
        if (!$where) {
            $where = array($this->pk => $this->attributes[$this->pk]);
        }
        $this->connection->delete($this->table, $where);
        return $this;
    }

    public function updateAll($data) {
        return $this->connection->update($this->table, $data);
    }

    public function first() {
        $result = $this->connection->select()
                ->from($this->table)
                ->limit(0, 1)
                ->orderBy($this->pk, 'ASC')
                ->get()
                ->fetchAssoc();
        return reset($result);
    }

    public function last() {
        $result = $this->connection->select()
                ->from($this->table)
                ->orderBy($this->pk, 'ASC')
                ->get()
                ->fetchAssoc();
        return end($result);
    }

    private function validate() {
        $validate = new Validator();
        $validate->setAttributes($this->attributes);
        $validate->addRules($this->rules());
        $result = $validate->validate();
        $error = $validate->getErrors();
        Base::instance()->session->setFlashData('error', $error);
        return $result;
    }

    abstract public function rules();
}
