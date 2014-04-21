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

class Oracle {

    private $db;

    public function __construct() {
        $this->db = Database::getDBConnection('oci');
    }

    public function showTableTest() {
        return $this->db->listTable();
    }

    public function showColumnTest() {
        return $this->db->listColumn("employees");
    }

    public function insert() {
        $data = array(
            'EMPLOYEE_ID' => '247',
            'FIRST_NAME' => 'masfu',
            'LAST_NAME' => 'hisyam',
            'EMAIL' => 'al_hisyam@myself.com',
            'PHONE_NUMBER' => '45.54.44',
            'HIRE_DATE' => '07-JUN-94',
            'JOB_ID' => 'AC_ACCOUNT',
            'SALARY' => '1234',
            'COMMISSION_PCT' => '0.1',
            'MANAGER_ID' => '123',
            'DEPARTMENT_ID' => '50');

        return $this->db->insert("employees", $data);
    }

    public function update() {
        $data = array(
            'FIRST_NAME' => 'masfu',
            'LAST_NAME' => 'arin',
            'EMAIL' => 'al_hisyam@myself.com',
            'PHONE_NUMBER' => '45.54.44',
            'HIRE_DATE' => '07-JUN-94',
            'JOB_ID' => 'AC_ACCOUNT',
            'SALARY' => '1234',
            'COMMISSION_PCT' => '0.1',
            'MANAGER_ID' => '123',
            'DEPARTMENT_ID' => '50');

        return $this->db->update("employees", $data, array('EMPLOYEE_ID' => 247));
    }

    public function delete() {
        return $this->db->delete("employees", array('EMPLOYEE_ID' => 247));
    }

    public function select() {
        return $this->db->select("*")
                        ->from("employees")
                        ->result()
                        ->fetchArray();
    }

}
