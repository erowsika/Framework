<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\auth;

/**
 * Description of BasicAuth
 *
 * @author masfu
 *  inspired by http://evertpot.com/223/
 */
class BasicAuth {

    private $password;
    private $username;

    public function __construct() {

        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $this->username = $_SERVER['PHP_AUTH_USER'];
            $this->password = $_SERVER['PHP_AUTH_PW'];
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']), 'basic') === 0)
                list($this->username, $this->password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        }
    }

    /**
     * 
     * @return boolean
     */
    public function isLoggedIn() {
        if (is_null($this->username)) {
            return false;
        }
        return true;
    }

    /**
     * 
     */
    public function restrict() {
        if (!$this->isLoggedIn()) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo "you're not authorized to access this page";
            die();
        }
    }

}
