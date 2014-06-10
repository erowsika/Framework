<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache;

/**
 * Description of BaseCache
 *
 * @author masfu
 */
class BaseCache {

    /**
     * config object
     * @var string
     */
    public $config = array();
    
    /**
     * storage type
     * @var string  
     */
    public $storage = "";
    
    /**
     * option
     * @var array 
     */
    public $option = array();
    
    /**
     * path directory
     * @var string 
     */
    public $path = "";

    /**
     * set data cache
     * @param string $key
     * @param string $value
     * @param string $time
     * @param string $option
     */
    public function set($key, $value, $time = 600, $isOverwrite = true) {
        $this->_set($key, $value, $time, $isOverwrite);
    }

    /**
     * get data cache
     * @param string $key
     * @param string $option
     * @return string
     */
    public function get($key) {
        return $this->_get($key);
    }

    /**
     * delete cache data
     * @param string $key
     * @param string $option
     * @return string
     */
    public function delete($key) {
        return $this->_delete($key, $option);
    }

    /**
     * flush data cache
     */
    public function flush() {
        $this->_flush();
    }

}
