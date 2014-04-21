<?php

/**
 * Description of Registry is store an instance of class 
 * that we have create before and also to provide auto load mechanism
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class Registry {
    /* store object 
     * @var string
     * @access private
     */

    private $registry = array();

    /* store the instance of this class (Singleton)
     * @var Registry
     */
    private static $instance = null;

    /*
     * constructor
     */

    public function __construct($properti = array()) {
        if (!empty($properti))
            $this->registry = $properti;
    }

    /**
     * get the instance of this class without create an object 
     * @access static
     * @return Registry
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }

    /**
     * set this property
     * @param array $properti
     */
    public function setProperty($properti = array()) {
        $this->registry = $properti;
    }

    /**
     * ger property
     * @return array
     */
    public function getProperty() {
        return $this->registry;
    }

    /*
     * set or store object
     * @param string
     * @param object
     */

    public function set($name, $value) {
        if (!isset($this->registry[$name])) {
            $this->registry[$name] = $value;
        }
    }

    /*
     * get the object 
     * @param string
     * @return object
     */

    public function get($key) {
        return (isset($this->registry[$key])) ? $this->registry[$key] : false;
    }

}
