<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of Crud
 *
 * @author masfu
 */
use system\service\RestController;

class RestTest extends RestController {

    public function __construct() {
        parent::__construct();
    }

    public function access() {
        return array(
            array('grant',
                'executes' => array('login'),
                'user' => array('admin', 'operator')),
            array('revoke',
                'executes' => array('login'),
                'user' => array('guest'))
        );
    }

    public function login() {
        $data = array('nama' => 'masfu', 'tgl_lahir' => '19-08-1993');
        $this->outputJson($data);
    }

}
