<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\auth;

/**
 * Description of AccessControl
 *
 * @author masfu
 */
use system\core\Base;

class AccessControl {

    private $method;
    private $rules = array();
    private $auth;
    private $loginUrl;

    public function __construct() {
        $this->method = Base::instance()->router->getMethod();
        $this->auth = Base::instance()->auth;
        $this->loginUrl = Base::instance()->base_url;
    }

    public function setLoginUrl($loginUrl) {
        $this->loginUrl = $loginUrl;
    }

    public function setRules(Array $rules) {
        $this->rules = $rules;
    }

    public function checkAccess() {
        foreach ($rules as $rule) {
            $executes = $rule['executes'];
            $accessType = reset($rule);
            if (in_array($method, $executes)) {
                if (isset($rule['user'])) {
                    $userList = $rule['user'];
                    $user = $auth->getUser();
                } else {
                    $roleList = $rule['role'];
                    $role = $auth->getRole();
                }
            }
        }
    }

    private function checkPermission($accessList, $accessType, $user) {

        $hasAuth = in_array($user, $accessList);
        if ($accessType == 'grant' and $hasAuth) {
            return true;
        } else if ($accessType == 'revoke' and $hasAuth) {
            throw new HttpException('you are not allowed to access this page', 403);
        }
    }

}
