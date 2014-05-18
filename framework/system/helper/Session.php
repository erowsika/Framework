<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Session inspiration from code igniter
 *
 * @author masfu
 */
use system\core\Config;

class Session {

    /**
     * store config
     * @var array 
     */
    private $config = array();

    /**
     * constructor
     */
    public function __construct() {
        $this->config = Config::getInstance()->get('session');
        session_name($this->config['session_name']);
        session_start();
    }

    public function getUniqueId() {
        return session_id();
    }

    /**
     * magical method to get session data
     * @param string $key
     * @return string
     */
    public function __get($key) {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
    }

    /**
     * magical method to set session data
     * @param string $name
     * @param data $value
     */
    public function __set($name, $value) {
        $this->setTimeExpire();
        $_SESSION[$name] = $value;
    }

    /**
     * unset session data
     * @param string $name
     */
    public function unsetSess($name) {
        unset($_SESSION[$name]);
    }

    /**
     * set message flash message that will unset on the next request
     * @param string $name
     * @param sting $value
     */
    public function setFlashData($name, $value) {
        $_SESSION['flash_data'][$name] = $value;
    }

    /**
     * get flash message data
     * @param string $name
     * @return string
     */
    public function flashData($name) {
       // unset($_SESSION['flash_data'][$name]);
       return (isset($_SESSION['flash_data'][$name])) ? $_SESSION['flash_data'][$name] : false;
    }

    /**
     * set session expiration time
     */
    public function setTimeExpire() {
        $_SESSION['sess_expiration'] = time() + $this->config['session_expire'];
    }

    /**
     * destructor
     */
    public function __destruct() {
        $this->destroy();
    }

    /**
     * destroy session
     */
    public function destroy() {
        @session_destroy();
    }

}
