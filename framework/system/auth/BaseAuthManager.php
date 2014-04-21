<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\auth;

/**
 * Description of AuthManager
 *
 * @author masfu
 */
use system\core\Base;
use system\core\MainException;

class BaseAuthManager extends Session {

    protected $username;
    protected $password;
    protected $remember;
    protected $loginUrl;
    protected $user = array();
    protected $permission = array();

    public function __construct() {
        parent::__construct();
    }

    public function authenticate() {
        throw new MainException("Unimplemented yet");
    }

    public function checkPermission() {
        $base = Base::instance();
        $controllerName = $base->router->getController();
        $method_name = $base->router->getController();
        $controller = $base->$controllerName;
        if (method_exists($controller, 'permission')) {
            $this->permission = $controller->permission();
        }
    }

}
