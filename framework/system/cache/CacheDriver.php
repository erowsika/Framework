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

    public function __construct($config = array());

    public function _set($key, $value = "", $time = 600, $isOverwrite = true);

    public function _get($key);

    public function _delete($key);

    public function _flush();

    public function _increment($key, $offset = 1);

    public function _decrement($key, $offset = 1);
}
