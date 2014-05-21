<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\core;

/**
 * Description of Input
 *
 * @author masfu
 */
class Input {

    const HEAD = 'HEAD';
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const OPTIONS = 'OPTIONS';
    const OVERRIDE = '_METHOD';

    /**
     * check is ajax request
     * @return type
     */
    public function isAjax() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false;
    }

    /**
     * get method request
     * @return string
     */
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * check if request is get
     * @return boolean
     */
    public function isGet() {
        return $this->getMethod() == self::GET;
    }

    /**
     * check if request is post
     * @return boolean
     */
    public function isPost() {
        return $this->getMethod() == self::POST;
    }

    /**
     * check if request is put
     * @return booloan
     */
    public function isPut() {
        return $this->getMethod() == self::PUT;
    }

    /**
     * check if request is pacth
     * @return booloan
     */
    public function isPatch() {
        return $this->getMethod() == self::PATCH;
    }

    /**
     * check if request is delete
     * @return booloan
     */
    public function isDelete() {
        return $this->getMethod() == self::DELETE;
    }

    /**
     * check if request is head
     * @return booloan
     */
    public function isHead() {
        return $this->getMethod() == self::HEAD;
    }

    /**
     * check if request is option
     * @return booloan
     */
    public function isOptions() {
        return $this->getMethod() == self::OPTIONS;
    }

    /**
     * 
     * @param type $key
     * @param type $xss_clean
     * @return type
     */
    public function getCookie($key = null, $xss_clean = false) {
        $value = $_COOKIE;
        return $this->filter($value, $key, $xss_clean);
    }

    /**
     * set cookie 
     * @param string $name
     * @param string $value
     * @param int $expire 60*60*24*30
     * @param string $path default null
     * @param string $domain
     * @param string $secure
     */
    public function setCookie($name, $value, $expire = 2592000, $path = '', $domain = '', $secure = '') {
        setcookie($name, $value, $expire, $path, $domain, $secure);
    }

    /**
     * get input data from $_POST variable
     * @param string $key
     * @param boolean $xss_clean
     * @return string
     */
    public function post($key = null, $default = null) {

        if ($key == null) {
            return $_POST;
        }

        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return $default;
    }

    /**
     * get input data form $_GET variable
     * @param string $key
     * @param boolean $xss_clean
     * @return string
     * 
     */
    public function get($key = null, $default = null) {
        if ($key == null) {
            return $_GET;
        }

        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return $default;
    }

    /**
     * get put data
     * @param stirng $key
     * @param string $default
     * @return string
     */
    public function put($key = null, $default = null) {
        return $this->post($key, $default);
    }

    /**
     * get pacth data
     * @param stirng $key
     * @param string $default
     * @return string
     */
    public function pacth($key = null, $default = null) {
        return $this->post($key, $default);
    }

    /**
     * get delete data
     * @param stirng $key
     * @param string $default
     * @return string
     */
    public function delete($key = null, $default = null) {
        return $this->post($key, $default);
    }

    

}
