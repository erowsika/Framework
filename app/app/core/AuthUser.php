<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core;

/**
 * Description of AuthUser
 *
 * @author masfu
 */
use system\auth\BaseAuthManager;

class AuthUser extends BaseAuthManager {

    public function __construct() {
        parent::__construct();
    }

    public function authenticate(){
        
    }
}
