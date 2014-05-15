<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache;

/**
 * Description of Cachee
 *
 * @author masfu
 */
use system\cache\driver as driver;
use system\core\MainException;
use system\core\Config;

class Cache {

    private $cache = null;

    public function __construct() {
        $config = Config::getInstance()->get('cache');

        switch ($config['driver']) {
            case 'apc':
                $this->cache = new driver\ApcCache($config);
                break;
            case 'memcache':
                $this->cache = new driver\MemCache($config);
                break;
            case 'memcached':
                $this->cache = new driver\MemCached($config);
                break;
            case 'file':
                $this->cache = new driver\FileCache($config);
                break;
            default:
                throw new MainException('cache driver not found check your config file');
                break;
        }
    }

    public function __call($name, $parameter) {
        
        return call_user_func_array(array(&$this->cache, $name), $parameter);
    }

}
