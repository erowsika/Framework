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
     *
     * @var  
     */
    public $storage = "";
    
    /**
     * option
     * @var array 
     */
    public $option = array();
    
    /**
     *
     * @var string 
     */
    public $path = "";

    /**
     * 
     * @param type $key
     * @param type $value
     * @param type $time
     * @param type $option
     */
    public function set($key, $value, $time = 600, $isOverwrite = true) {
        $this->_set($key, $value, $time, $isOverwrite);
    }

    /**
     * 
     * @param type $key
     * @param type $option
     * @return type
     */
    public function get($key) {
        return $this->_get($key);
    }

    /**
     * 
     * @param type $key
     * @param type $option
     * @return type
     */
    public function delete($key) {
        return $this->_delete($key, $option);
    }

    /**
     * 
     * @param type $option
     */
    public function flush() {
        $this->_flush();
    }

}
