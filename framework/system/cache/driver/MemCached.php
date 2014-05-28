<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache\driver;

/**
 * Description of MemCached
 *  inspiring from http://evertpot.com/107/
 * @author masfu
 */
use system\cache\BaseCache;
use system\cache\CacheDriver;
use system\core\MainException;

class MemCached extends BaseCache implements CacheDriver {

    public $memcached = null;

    /**
     * 
     * @param type $config
     * @throws MainException
     */
    public function __construct($config = array()) {
        if (!extension_loaded('memcached'))
            throw new MainException('Memcache extension is not installed');

        $this->memcached = new \Memcached();
        if ($this->memcached->connect($config['host'], $config['port'])) {
            throw new MainException('Could not connect memcache server');
        }
    }

    /**
     * 
     * @param type $key
     */
    public function _delete($key) {
        $this->memcached->delete($key);
    }

    /**
     * 
     */
    public function _flush() {
        $this->memcached->flush();
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function _get($key) {
        $value = $this->memcached->get($key);
        return ($value == null) ? null : $value;
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @param type $time
     * @param type $isOverwrite
     */
    public function _set($key, $value = "", $time = 600, $isOverwrite = true) {
        $this->memcached->set($key, $value, $time);
    }

    /**
     * 
     * @param type $key
     * @param type $offset
     */
    public function _decrement($key, $offset = 1) {
        $this->memcached->decrement($key, $offset);
    }

    /**
     * 
     * @param type $key
     * @param type $offset
     */
    public function _increment($key, $offset = 1) {
        $this->memcached->increment($key, $offset);
    }

//put your code here
}
