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

abstract class BaseAuthManager {

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
    public $error_message = array('1' => 'username not found',
        '2' => 'password did not match');

    /**
     * 
     */
    public function __construct() {
        $this->session = Base::instance()->session;
    }

    /**
     * 
     * @return type
     */
    public function isGuest() {
        return $this->session->is_logged_id ? true : false;
    }

    /**
     * 
     * @param type $user
     * @return boolean
     */
    public function access($user) {
        return false;
    }

    /**
     * 
     * @return null
     */
    public function getUser() {
        if (!is_null($this->user)) {
            return $this->user;
        }

        return null;
    }

    /**
     * 
     * @param type $name
     * @param type $value
     */
    public function setRemember($name, $value) {
        if (is_array($value)) {
            $value = base64_encode(serialize($value));
        }
        Base::instance()->input->setCookie($name, $value);
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    public function getRemember($name) {
        $value = Base::instance()->input->getCookie($name);
        if (($data = unserialize($value))) {
            $value = base64_decode($data);
        }
        return $value;
    }

    /**
     * 
     * @return type
     */
    public function getUserRole() {
        return $this->user_role;
    }

    /**
     * 
     * @param type $role
     */
    public function setUserRole($role) {
        $this->user_role = $role;
    }

    public function signOut() {
        
    }
}
