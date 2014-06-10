<?php

/**
 * Description of Config
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class Config {
    
    /*
     * @var registry
     */
    private $vars;
    
    /**
     * instance
     * @var Config 
     */
    private static $_instance;

    /*
     * constructor
     */

    public function __construct($conf = null) {
        $property = array();
        if ($conf == null) {
            $property = include(CONFIG_PATH . '/application.php');
        }
        $this->vars = $property;
    }

    /**
     * get instance
     * @return Config
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    /*
     * get value according the key
     * @var string
     * @return string
     */

    public function get($key = null) {
        $value = isset($this->vars[$key]) ? $this->vars[$key] : false;
        return $value;
    }

    /* set value 
     * @var string
     * @var string
     */

    public function set($key, $value) {
        $this->vars[$key] = $value;
    }

    /**
     * get property
     * @return array
     */
    public function getProperty(){
        return $this->vars;
    }
}
