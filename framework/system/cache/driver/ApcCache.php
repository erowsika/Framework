<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache\driver;

/**
 * Description of ApcCache
 *
 * @author masfu
 */
use system\cache\BaseCache;
use system\cache\CacheDriver;
use system\core\MainException;

class ApcCache extends BaseCache implements CacheDriver {

    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {

        if (!(extension_loaded('apc') and ini_get('apc.enabled'))) {
            throw new MainException("Apc is not enabled");
        }
        $this->config = $config;
    }

    /**
     * 
     * @param type $key
     * @param type $option
     */
    public function _delete($key) {
        return apc_delete($key);
    }

    /**
     * 
     * @param type $option
     */
    public function _flush() {
        apc_clear_cache();
        apc_clear_cache("user");
    }

    /**
     * 
     * @param type $key
     * @param type $option
     */
    public function _get($key) {
        $data = apc_fetch($key, $status);
        if (!$status) {
            return null;
        }
        return $data;
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @param type $time
     * @param type $option
     */
    public function _set($key, $value = "", $time = 600, $isOverwrite = true) {
        if ($isOverwrite) {
            return apc_add($key, $value, $time);
        } else {
            return apc_store($key, $value, $time);
        }
    }

    /**
     * 
     * @param type $key
     * @param type $offset
     * @return type
     */
    public function _decrement($key, $offset = 1) {
        return apc_dec($key, $offset);
    }

    /**
     * 
     * @param type $key
     * @param type $offset
     * @return type
     */
    public function _increment($key, $offset = 1) {
        return apc_inc($key, $offset);
    }

//put your code here
}
