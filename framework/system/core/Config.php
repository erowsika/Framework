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

    public function __construct($conf = 'application') {
        $this->vars = $this->parse($conf);
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
        if (!isset($this->vars[$key])) {
            $this->vars[$key] = $this->parse($key);
        }
        return $this->vars[$key];
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
    public function getProperty() {
        return $this->vars;
    }

    /**
     * 
     */
    public function parse($conf) {
        $property = array();
        $filename = CONFIG_PATH . DIRECTORY_SEPARATOR . $conf.EXT_FILE;
        if (file_exists($filename)) {
            $property = include($filename);
        } else {
            throw new MainException('file config ' . $filename . ' is not found');
        }
        return $property;
    }

}
