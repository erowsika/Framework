<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Mysql
 *
 * @author masfu
 */
use system\db\Database;

class Pdo {

    private $db;

    public function __construct() {
        $this->db = Database::getConnection('pdo');
    }

    public function showTableTest() {
        return $this->db->tables();
    }

    public function showColumnTest() {
        return $this->db->column("santri");
    }

    public function insert() {
        $data = array(
            'nama_santri' => 'masfu',
            'alamat_santri' => 'rumah',
            'tmp_lahir_santri' => 'sby',
            'tahun_masuk' => '1994');

        return $this->db->insert("santri", $data);
    }

    public function update() {
        $data = array(
            'nama_santri' => 'arin',
            'alamat_santri' => 'rumah',
            'tmp_lahir_santri' => 'sby',
            'tahun_masuk' => '1995');

        return $this->db->update("santri", $data, array('santri_id' => 63));
    }

    public function delete() {
        return $this->db->delete("santri", array('santri_id' => 67));
    }

    public function select() {
        return $this->db->select("*")
                        ->from("account")
                        ->limit(10,2)
                        //->orderBy("tahun_masuk", "DESC")
                        ->get()
                        ->fetchAssoc();
    }

}
