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

namespace models;

use db;

class User {

    private $db;

    public function __construct() {
        $this->db = db\SqlProvider::getDBConnection('db');
        
    }

}
