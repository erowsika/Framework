<?php

/**
 * Description of Registry is store an instance of class 
 * that we have create before and also to provide auto load mechanism
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace sby\core;

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

    private function __construct() {
        
    }

    /*
     * magic method
     */

    private function __clone() {
        
    }

    /* get the instance of this class without create an object 
     * @access static
     * @return Registry
     */

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Registry();
        }

        return self::$instance;
    }

    /*
     * set or store object
     * @param string
     * @param object
     */

    public function set($key, $value) {
        if (isset($this->registry[$key])) {
            throw new Exception("There is already an entry for key " . $key);
        }

        $this->registry[$key] = $value;
    }

    /*
     * get the object 
     * @param string
     * @return object
     */

    public function get($key) {
        if (!isset($this->registry[$key])) {
            throw new Exception("There is no entry for key " . $key);
        }

        return $this->registry[$key];
    }
}
