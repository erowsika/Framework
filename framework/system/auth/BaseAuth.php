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

class BaseAuth {

    /**
     * is remember
     * @var string 
     */
    public $remember;

    /**
     * login url
     * @var string 
     */
    public $loginUrl;

    /**
     * name of user
     * @var string 
     */
    private $user = 'guest';

    /**
     * error message
     */
    const USERNAME_ERROR = "username not found";
    const PASSWORD_ERROR = "password did not match";

    /**
     * public constructor
     */
    public function __construct() {
        $this->loginUrl = Base::instance()->base_url;
    }

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
     * get the current user
     * @return string
     */
    public function getUser() {
        $user = Base::instance()->session->getData('username');
        return ($user) ? $user : $this->user;
    }

    /**
     * set remember data
     * @param string $name
     * @param string $value
     */
    public function setRemember($name, $value) {
        if (is_array($value)) {
            $value = base64_encode(serialize($value));
        }
        Base::instance()->input->setCookie($name, $value);
    }

    /**
     * get remember data from cookie
     * @param string $name
     * @return string
     */
    public function getRemember($name) {
        $value = Base::instance()->input->getCookie($name);
        if (($data = unserialize($value))) {
            $value = base64_decode($data);
        }
        return $value;
    }

    /**
     * get role of the current user
     * @return string
     */
    public function getRole() {
        return Base::instance()->session->getData('role');
    }

    /**
     * set role of the current user
     * @param type $role
     */
    public function setRole($role) {
        Base::instance()->session->setData('role', $role);
    }

    /**
     * logout user
     */
    public function signOut() {
        Base::instance()->session->destroy();
    }

}
