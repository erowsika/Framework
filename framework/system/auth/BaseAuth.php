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

abstract class BaseAuth {

    /**
     *
     * @var type 
     */
    public $remember;
    public $login_url;
    public $permission = array();
    private $user = 'guest';

    const USERNAME_ERROR = "username not found";
    const PASSWORD_ERROR = "password did not match";

    /**
     * check is user has logged in
     * @return type
     */
    public function isGuest() {
        return Base::instance()->session->getData('is_logged_id') ? true : false;
    }

    /**
     * set user
     * @param type $username
     */
    public function setUser($username) {
        Base::instance()->session->setData('username', $username);
    }

    /**
     * 
     * @return null
     */
    public function getUser() {
        $user = Base::instance()->session->getData('username');
        return ($user) ? $user : $this->user;
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
    public function getRole() {
        return Base::instance()->session->getData('role');
    }

    /**
     * 
     * @param type $role
     */
    public function setRole($role) {
        Base::instance()->session->setData('role', $role);
    }

    /**
     * 
     */
    public function signOut() {
        
    }

}
