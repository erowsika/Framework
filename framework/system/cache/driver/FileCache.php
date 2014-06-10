<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache\driver;

/**
 * Description of FileCahced
 * inspiring from http://evertpot.com/107/
 * @author masfu
 */
use system\cache\BaseCache;
use system\cache\CacheDriver;
use system\core\MainException;

class FileCache extends BaseCache implements CacheDriver {

    /**
     * public constructor
     * @param array $config
     */
    public function __construct($config = array()) {

        $this->config = $config;
    }

    /**
     * delete cache data
     * @param string $key
     * @param string $option
     * @return string
     */
    public function _delete($key) {
        $filename = $this->getFileName($key);
        if (file_exists($filename) || is_readable($filename)) {
            unlink($filename);
            return true;
        }
        return false;
    }

    /**
     * flush data cache
     */
    public function _flush() {
        $dir = (isset($this->config['path'])) ? isset($this->config['path']) : '/tmp/s_cache';
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file") && !is_link($dir)) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * get data cache
     * @param string $key
     * @param string $option
     * @return string
     */
    public function _get($key) {
        $filename = $this->getFileName($key);

        if (!file_exists($filename)) {
            return null;
        }

        if (!($handle = fopen($filename, 'r'))) {
            return null;
        }
        flock($handle, LOCK_SH);

        $value = file_get_contents($filename);
        fclose($handle);

        if (!($data = unserialize($value))) {
            unlink($filename);
            return null;
        }
        if (time() > $data['time']) {
            unlink($filename);
            return null;
        }
        return $data['data'];
    }

    /**
     * set data cache
     * @param string $key
     * @param string $value
     * @param string $time
     * @param string $option
     */
    public function _set($key, $value = "", $time = 600, $isOverwrite = true) {
        $filename = $this->getFileName($key);


        if (!($handle = fopen($filename, 'w'))) {
            throw new MainException("could not open file");
        }
        //mutex
        flock($handle, LOCK_EX);
        fseek($handle, 0);
        ftruncate($handle, 0);

        $data = serialize(array('time' => (int) (time() + $time),
            'data' => $value));
        if (!fwrite($handle, $data)) {
            throw new MainException("could not open file to write cache");
        }
        fclose($handle);
    }

    /**
     * get file name
     * @param string $key
     * @return string
     */
    public function getFileName($key) {
        $path = (isset($this->config['path'])) ? $this->config['path'] : CACHE_PATH;
        $key = md5($key);
        return $path . DIRECTORY_SEPARATOR . $key;
    }

    /**
     * decrement
     * @param string $key
     * @param string $offset
     * @return string
     */
    public function _decrement($key, $offset = 1) {
        
    }

    /**
     * increment
     * @param string $key
     * @param string $offset
     * @return string
     */
    public function _increment($key, $offset = 1) {
        
    }

//put your code here
}
