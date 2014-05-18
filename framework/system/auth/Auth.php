<<<<<<< HEAD
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

    /**
     *
     * @var type 
     */
    public $remember;
    public $login_url;
    public $user_role;
    public $user;
    public $permission = array();
    private $session = null;
    private $_roles = array();

    /**
     * 
     */
    public function __construct() {
        $this->session = Base::instance()->session;
    }

    public function isGuest() {
        return $this->session->is_logged_id ? true : false;
    }

    public function access($user) {
        return false;
    }

    public function getUser() {
        if (!is_null($this->user)) {
            return $this->user;
        }

        return null;
    }

    public function setRemember($name, $value) {
        if (is_array($value)) {
            $value = base64_encode(serialize($value));
        }
        Base::instance()->input->setCookie($name, $value);
    }

    public function getRemember($name) {
        $value = Base::instance()->input->getCookie($name);
        if (($data = unserialize($value))) {
            $value = base64_decode($data);
        }
        return $value;
    }

    public function getUserRole() {
        return $this->user_role;
    }

    public function setUserRole($role) {
        $this->user_role = $role;
    }

    abstract public function role();
}
=======
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
>>>>>>> b712582a47ecad6b4a21913d50954f94eea2aac0
