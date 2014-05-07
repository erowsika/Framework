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

class MongoDb {

    private $db;

    public function __construct() {
        $this->db = Database::getConnection('mongo');
        $this->db->collection("people");
    }

    public function showTableTest() {
        return $this->db->selectDB('test');
    }

    public function showColumnTest() {
        return $this->db->columns("santri");
    }

    public function insert() {
        $data = array(
            'nama_santri' => 'arin',
            'alamat_santri' => 'rumah',
            'tmp_lahir_santri' => 'sby',
            'tahun_masuk' => '1994');

        return $this->db->insert($data);
    }

    public function update() {
        $data = array(
            'nama_santri' => 'arin',
            'alamat_santri' => 'rumah',
            'tmp_lahir_santri' => 'sby',
            'tahun_masuk' => '1995');

        return $this->db->update("people", $data, array('santri_id' => 70));
    }

    public function delete() {
        return $this->db->delete("people", array('santri_id' => 67));
    }

    public function select() {
        //$qry = array("nama_santri" => "masfu");
        return $this->db->findOne();
    }

}
