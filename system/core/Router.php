<?php

/**
 * Description of Router is a class to handle Url path
 * @package Sby/Core
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class Router {
    /*
     * 
     * class name of controller to be invoked
     * @var String  
     */

    private $controller;

    /* function name of class to be invoked
     * $var String
     */
    private $method;

    /* array to store parameter from url
     * @var array
     */
    private $parameter = array();

    /* store url link
     * @var string
     */
    private $uri;


    /*
     *  store rules from config file
     * @var array
     */
    private $request;

    /*
     * config
     * @var Config
     */
    private $config;

    /*
     * segmen url
     * 
     * 
     */
    private $segments = array();

    /*
     * constructor
     */

    public function __construct() {
        $this->uri = (isset($_SERVER['PATH_INFO'])) ? rtrim($_SERVER['PATH_INFO'], "\/") : '/';
        $this->config = new Config();
        $this->request = $this->config->get('router');
        
        $this->execute();
        
    }

    /*
     * exceute parsing route
     * @return void
     * 
     */
    public function execute() {

        //if url is the root
        if ($this->uri != '/') {
            if (!($this->segments = $this->parse())) {
                $route = $this->defaultRoute();
            }
        }
        $this->setRoute();
    }

    /*
     * set default route with segment based rule /controller/method/parameter
     * @return void
     * 
     */
    public function defaultRoute() {
        foreach (explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->uri)) as $val) {
            $val = trim($val);
            if ($val != '') {
                $this->segments[] = $val;
            }
        }
    }

    /*
     * assign segment array into controller, method, and parameter
     * @return void
     * 
     */

    public function setRoute() {
        
        $this->controller = isset($this->segments[0]) ? $this->segments[0] : $this->request['controller'];
        
        $this->method = isset($this->segments[1]) ? $this->segments[1] : 'index';
        
        $this->parameter = isset($this->segments[2]) ? array_slice($this->segments, 2) : array();
    }

    /*
     * parse and match router from config file
     * @return void
     * 
     */

    public function parse() {

        if (!empty($this->request)) {

            foreach ($this->request as $k => $v) {
                if (is_array($v) and $k !== 'parameter') {
                    $this->parameter = $this->request['parameter'];
                    $v['request'] = preg_replace_callback("/\<(?<key>[0-9a-z_]+)\>/", array(get_class($this), 'replacer'), str_replace(")", ")?", $v['request'])
                    );
                    $rulleTemp = array_merge((array) $this->request, (array) $v);
                    if (($route = $this->reportRulle($rulleTemp, $this->uri))) {
                        return $route;
                    }
                }
            }
        } else
            return array();
    }

    /*
     * replace reg exp
     */

    private function replacer($matches) {
        if (isset($this->parameter[$matches['key']])) {
            return "(?<" . $matches['key'] . ">" . $this->parameter[$matches['key']] . ")";
        } else
            return "(?<" . $matches['key'] . ">" . "([^/]+)" . ")";
    }

    private function reportRulle($ini_array, $uri) {
        if (is_array($ini_array) and $uri) {
            if (preg_match("#^" . $ini_array['request'] . "$#", $uri, $match)) {
                $r = array_merge((array) $ini_array, (array) $match);
                foreach ($r as $k => $v)
                    if ((int) $k OR $k == 'parameter' OR $k == 'request')
                        unset($r[$k]);
                return $r;
            }
        }
    }

    /* get controller name from url request
     * return string
     */

    public function getController() {
        return $this->controller;
    }

    /* get method name from url request
     * @return string
     */

    public function getMethod() {
        return $this->method;
    }

    /* get parameter name from url request
     * @return string
     */

    public function getParameter() {
        return $this->parameter;
    }

}
