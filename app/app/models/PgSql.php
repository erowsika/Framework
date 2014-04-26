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

class PgSql {

    private $db;

    public function __construct() {
        $this->db = Database::getDBConnection('pgsql');
    }

    public function showTableTest() {
        return $this->db->listTable();
    }

    public function showColumnTest() {
        return $this->db->listColumn("account");
    }

    public function insert() {
        $data = array(
            'username' => "rumah",
            'password' => "ddssfs",
            'email' => "al_hisyam@myself.com");

        return $this->db->insert("account", $data);
    }

    public function update() {
        $data = array(
            'username' => "dia",
            'password' => "ddssfs",
            'email' => "al_hisyam@myself.com");

        return $this->db->update("account", $data, array('user_id' => 5));
    }

    public function delete() {
        return $this->db->delete("account", array('user_id' => 5));
    }

    public function select() {
        return $this->db->select("*")
                        ->from("account")
                        ->result()
                        ->fetchArray();
    }

}
