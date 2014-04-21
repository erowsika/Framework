<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace app\models;

use \system\db as db;


class User extends db\ActiveRecord {

    private $db;

    public function __construct() {
        
    }

    public function getSantri() {
        $db = \Sby::instance()->db->createDb();
        $hasil = $db->query('select * from santri');
        $data = $hasil->fetchArray();
        foreach ($data as $value) {
            print_r($value);
        }
    }

}
