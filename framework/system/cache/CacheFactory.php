<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache;

/**
 * Description of cache 
 *
 * @author masfu
 */
use system\cache\driver as driver;
use system\core\MainException;
use system\core\Config;
use system\core\Factory;

class CacheFactory implements Factory {

    /**
     * public constructor
     * @throws MainException
     */
    public function __construct() { }

    /**
     * 
     * @return type
     * @throws MainException
     */
    public function create() {
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
        return $this->cache;
    }

}
