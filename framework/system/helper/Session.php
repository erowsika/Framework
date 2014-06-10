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
    private static $_instance;
    /**
     * config variable
     * @var array 
     */
    private $config = array();
    /**
     * message variable
     * @var string 
     */
    protected $messages;

    const FLASH = 'flash';

    /**
     * public constructor
     */
    public function __construct() {
        $this->config = Config::getInstance()->get('session');
        $name = $this->config['session_name'];
        session_name($name);
        session_start();

        $this->messages = array(
            'prev' => array(),
            'next' => array(),
            'now' => array()
        );

        $this->loadMessages();
        $this->save();
    }

    /**
     * get data instance
     * @return string
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * get unique data
     * @return string
     */
    public function getUniqueId() {
        return session_id();
    }

    /**
     * unset session data
     * @param string $name
     */
    public function unsetSess($name) {
        unset($_SESSION[$name]);
    }

    /**
     * get user data
     * @param string $key
     * @return string
     */
    public function getData($key) {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
    }

    /**
     * set data
     * @param string $name
     * @param string $value
     */
    public function setData($name, $value) {
        $this->setTimeExpire();
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $_SESSION[$key] = $value;
            }
        } else {
            $_SESSION[$name] = $value;
        }
    }

    /**
     * set message flash message that will unset on the next request
     * @param string $name
     * @param sting $value
     */
    public function setFlashData($key, $value) {
        $this->messages['next'][$key] = $value;
        $this->save();
        $this->keepFlashData($key);
    }

    /**
     * keep flash data
     * @param string $key
     */
    public function keepFlashData($key) {
        foreach ($this->messages['prev'] as $key => $val) {
            $this->messages['next'][$key] = $val;
        }
    }

    public function save() {
        $_SESSION[self::FLASH] = $this->messages['next'];
    }

    /**
     * Load messages from previous request if available
     */
    public function loadMessages() {
        if (isset($_SESSION[self::FLASH])) {
            $this->messages['prev'] = $_SESSION[self::FLASH];
        }
    }

    /**
     * get flash message data
     * @param string $name
     * @return string
     */
    public function flashData($key) {
        $data = isset($this->messages['next'][$key]) ? $this->messages['next'][$key] : '';
        return $data;
    }

    /**
     * set session expiration time
     */
    public function setTimeExpire() {
        $_SESSION['sess_expiration'] = time() + $this->config['session_expire'];
    }
    
    /**
     * destroy session
     */
    public function destroy() {
        @session_destroy();
    }

}
