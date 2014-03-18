<?php

/**
 * Description of Sby
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace sby\core;

class Base {
    /*
     * this variable store the instance of the sby class
     * @var Sby
     * @access private
     */

    private static $_instance;

    /* varible registry
     * @var Registry
     */
    private $_config;

    /* this is a constructor
     * @access public
     * 
     */

    public function __construct() {
        $this->init();
    }

    /* get instance (Singleton)
     * 
     */

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Base();
        }
        return self::$_instance;
    }

    /*
     * initialization
     * 
     */

    public function init() {
        $this->_config = new Config();
        $this->initConfig();
    }

    /*
     * initialization config file
     */

    private function initConfig() {
        $conf = $this->_config->get();
        foreach ($conf as $key => $value) {
            if (!is_array($value)) {
                $this->$key = $value;
            }
        }
    }

    private function initClass() {
        $conf = $this->_config->get();
        foreach ($conf as $key => $value) {
            if (!is_array($value)) {
                $this->$key = $value;
            }
        }
    }

    /*
     * run application
     */

    public function run() {
        echo "hello world";
    }

    public function __get($varName) {
        return $this->_config->get($varName);
    }

    public function __set($varName, $value) {
        $this->_config->set($varName, $value);
    }

}

?>
