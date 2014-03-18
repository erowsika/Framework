<?php

/**
 * Description of Config
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace sby\core;

class Config {
    /*
     * @var registry
     */

    private $_registry;

    /*
     * constructor
     */

    public function __construct($conf = null) {

        if ($conf == null) {
            $conf = include(CONFIG_PATH . '/application.php');
        }

        $this->_registry = Registry::getInstance($conf);
    }

    /*
     * get value according the key
     * @var string
     * @return string
     */

    public function get($key = null) {
        $value = $this->_registry->get($key);
        return $value;
    }

    /* set value 
     * @var string
     * @var string
     */

    public function set($key, $value) {
        $this->_registry->set($key, $value);
    }

}
