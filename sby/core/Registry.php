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

    private function __construct($properti) {
        $this->registry = $properti;
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

    public static function getInstance($properti) {
        if (self::$instance === null) {
            self::$instance = new Registry($properti);
        }
        return self::$instance;
    }

    /*
     * set or store object
     * @param string
     * @param object
     */

    public function set($key, $value) {
        if (!isset($this->registry[$key])) {
            $this->registry[$key] = $value;
        }
    }

    /*
     * get the object 
     * @param string
     * @return object
     */

    public function get($key = null) {

        if (!isset($this->registry[$key])) {
            return $this->registry;
        }

        return $this->registry[$key];
    }

}
