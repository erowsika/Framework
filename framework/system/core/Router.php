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
    private $action;

    /* array to store parameter from url
     * @var array
     */
    private $parameter = array();

    /* store url link
     * @var string
     */
    private $uri;


    /**
     *
     * @var type 
     */
    private $rules = array();

    /*
     * config
     * @var Config
     */
    private static $config;

    /*
     * segmen url
     * 
     * 
     */
    private $segments = array();

    /**
     *
     * @var type 
     */
    private $callback;
    /*
     * constructor
     */
    private $routes = array();
    
    
    
    private static $match = array();

    public function __construct() {
        $this->uri = (isset($_SERVER['PATH_INFO'])) ? rtrim($_SERVER['PATH_INFO'], "\/") : '/';
        $this->rules = Config::getInstance()->get('router');
        $this->parseRules();
        $this->execute();
    }

    /*
     * exceute parsing route
     * @return void
     * 
     */

    private function parseRules() {
        foreach ($this->rules as $key => $rule) {
            if (is_array($rule) and ! is_string($key)) {
                $this->routes[] = array('method' => $rule[0],
                    'pattern' => $rule[1],
                    'callback' => $rule[2]);
            } else
                self::$config[$key] = $rule;
        }
    }

    public function execute() {

        $paramRules = "/\<(?<key>[0-9a-z_]+)\>/";
        foreach ($this->routes as $key => $route) {

            $source = str_replace(")", ")?", $route['pattern']);

            $pattern = preg_replace_callback($paramRules, 'self::replacer', $source);
            $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

            if (preg_match($pattern, $this->uri, $params)) {
                array_shift($params);

                foreach (self::$config['parameter'] as $key => $value) {
                    if (isset($params[$key])) {
                        array_push($this->segments, $params[$key]);
                        self::$match[$key] = $params[$key];
                    }
                }
                $this->callback = preg_replace_callback($paramRules, 'self::replaceCallback', $route['callback']);
                $this->parseAction();
                return;
            }
        }
        $this->defaultRoute();
    }

    /**
     * 
     * @param type $pattern
     * @return type
     */
    private static function replaceCallback($pattern) {
        return isset(self::$match[$pattern['key']]) ? self::$match[$pattern['key']] : '';
    }

    /**
     * 
     * @param type $pattern
     * @return type
     */
    private static function replacer($pattern) {
        if (isset(self::$config['parameter'][$pattern['key']])) {
            return "(?<" . $pattern['key'] . ">" . self::$config['parameter'][$pattern['key']] . ")";
        }
        return "(?<" . $pattern['key'] . ">" . "([^/]+)" . ")";
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
        $this->controller = isset($this->segments[0]) ? $this->segments[0] : $this->rules['default_controller'];
        $this->action = isset($this->segments[1]) ? $this->segments[1] : 'index';
        $this->parameter = isset($this->segments[2]) ? array_slice($this->segments, 2) : array();
    }

    /**
     * 
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * 
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * 
     * @return type
     */
    public function getParameter() {
        return $this->parameter;
    }

    /**
     * 
     */
    private function parseAction() {

        $str = explode('@', $this->callback);
        $this->controller = reset($str);
        $param = explode('\\', end($str));

        $this->action = reset($param);
        $parameter = array_slice($param, 1);
        $this->parameter = array_merge($this->parameter, $parameter);
    }

    /**
     * get uri request
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

}
