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

class MemCache extends BaseCache implements CacheDriver {

    public $memcache = null;

    /**
     * public constructor
     * @param string $config
     * @throws MainException
     */
    public function __construct($config = array()) {

        if (!extension_loaded('memcache'))
            throw new MainException('Memcache extension is not installed');

        $this->memcache = new \Memcache();
        if ($this->memcache->connect($config['host'], $config['port'])) {
            throw new MainException('Could not connect memcache server');
        }
    }

    /**
     * delete cache data
     * @param string $key
     * @param string $option
     * @return string
     */
    public function delete($key) {
        $this->memcache->delete($key);
    }

    /**
     * flush data cache
     */
    public function flush() {
        $this->memcache->flush();
    }

    /**
     * get data cache
     * @param string $key
     * @param string $option
     * @return string
     */
    public function get($key) {
        $value = $this->memcache->get($key);
        return ($value == null) ? null : $value;
    }

    /**
     * set data cache
     * @param string $key
     * @param string $value
     * @param string $time
     * @param string $option
     */
    public function set($key, $value = "", $time = 600, $isOverwrite = true) {
        return $this->memcache->set($key, $value, $time);
    }

    /**
     * decrement
     * @param string $key
     * @param string $offset
     * @return string
     */
    public function decrement($key, $offset = 1) {
        $this->memcache->decrement($key, $offset);
    }

    /**
     * increment
     * @param string $key
     * @param string $offset
     * @return string
     */
    public function increment($key, $offset = 1) {
        $this->memcache->increment($key, $offset);
    }

//put your code here
}
