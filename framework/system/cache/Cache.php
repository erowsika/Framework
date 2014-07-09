<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache;

/**
 * Description of Cache
 *
 * @author masfu
 */
class Cache {
    
    private $cache;
    
    public function __construct() {
        $cache = new CacheFactory();
        $this->cache = $cache->create();
    }
    
    /**
     * magic method to call the function dynamically
     * @param string $name
     * @param string $parameter
     * @return string
     * @throws MainException
     */
    public function __call($name, $parameter) {
        if (method_exists($this->cache, $name)) {
            return call_user_func_array(array(&$this->cache, $name), $parameter);
        } else {
            throw new MainException("method {$name} doesn't exist");
        }
    }
    
}
