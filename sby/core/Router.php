<?php

/**
 * Description of Router is a class to handle Url path
 * @package Sby/Core
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace core;

class Router {
    
    /* class name of controller to be invoked
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
    private $parameter = [];
    
    /* store url link
     * @var string
     */
    private $request;

    public function __construct() {
        
        $this->request = $_SERVER[''];
        
    }

    public function parseUrl() {
        echo "okke";
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
