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
interface CacheDriver {

    /**
     * public constructor
     * @param array $config
     */
    public function __construct($config = array());

    /**
     * set cahce data
     * @param string $key
     * @param string $value
     * @param integer $time
     * @param boolean $isOverwrite
     */
    public function _set($key, $value = "", $time = 600, $isOverwrite = true);

    /**
     * get the cache data
     * @param string $key
     */
    public function _get($key);

    /**
     * delete the cache data
     * @param string $key
     */
    public function _delete($key);

    /**
     * flush data
     */
    public function _flush();

    /**
     * increment
     * @param string $key
     * @param string $offset
     */
    public function _increment($key, $offset = 1);

    /**
     * decrement
     * @param string $key
     * @param string $offset
     */
    public function _decrement($key, $offset = 1);
}
