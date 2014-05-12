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
use system\helper\Session;

abstract class Auth {

    public $remember;
    public $login_url;
    public $unique_id;
    public $user;
    public $permission = array();
    private $session = null;

    public function __construct() {
        $this->session = new Session();
        $this->unique_id = $this->session->getUniqueId();

        if ($this->unique_id) {
            $this->unique_id = $this->revalidate();
        }
    }

    public function isGuest() {
        return empty($this->user);
    }

    public function user() {
        if (!is_null($this->user))
            return $this->user;

        return null;
    }

    public function remember($unique_id) {
        $session_id = base64_encode($unique_id);
    }

    abstract public function authenticate($username, $password, $is_remember);
}
