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

    private $code = 200;
    private $contentType = "application/json";

    private function getStatusMessage() {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($status[$this->code]) ? $status[$this->code] : $status[500];
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function getServer($key) {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
    }
    
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
            return $this->cleanInputs($_POST);
        }

        if (isset($_POST[$key])) {
            return $this->cleanInputs($_POST[$key]);
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
            return $this->cleanInputs($_GET);
        }

        if (isset($_GET[$key])) {
            return $this->cleanInputs($_GET[$key]);
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
        $request = array();
        parse_str(file_get_contents("php://input"), $request);
        return $this->cleanInputs($request);
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

    /**
     * get remote ip
     * @return string
     */
    function getClientIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    /**
     * purify input
     * @param string $data
     * @return string
     */
    public function cleanInputs($data) {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }

    /**
     * get http referer
     * @return string
     */
    public function getReferer() {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * get user agent
     * @return type
     */
    public function getUserAgent(){
        return $_SERVER['HTTP_USER_AGENT'];
    }
    /**
     * response
     * @param string string
     * @param string integer
     */
    public function response($data, $contentType, $status = 200) {
        $this->code = $status;
        $this->contentType = $contentType;
        $this->setHeaders();
        echo $data;
        exit;
    }

    /**
     * set headers
     */
    private function setHeaders() {
        header("HTTP/1.1 " . $this->code . " " . $this->getStatusMessage());
        header("Content-Type:" . $this->contentType);
    }

}
