<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Utils
 *
 * @author masfu
 */
class Utils {

    /**
     * escape string data
     * @param string $str
     * @param boolean $xss_filter
     * @return string
     * 
     */
    public static function escapeStr($str, $xss_filter = false) {
        // $str = remove_invisible_characters($str);
        $str = addslashes($str);
        return ($xss_filter) ? $this->xssClean($str) : $str;
    }

    /**
     * remove dangerous string
     * @param string $val
     * @return string
     */
    public static function xssClean($val) {
        $val = htmlentities($val);
        $val = strip_tags($val);
        $val = filter_var($val, FILTER_SANITIZE_STRING);
        return $val;
    }

    /**
     * copy and make dir recursively
     * @param string $source
     * @param string $dest
     * @param integer $permissions
     * @return boolean
     */
    public static function xcopy($source, $dest, $permissions = 0755) {
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }
        if (is_file($source)) {
            return copy($source, $dest);
        }

        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $this->xcopy("$source/$entry", "$dest/$entry");
        }

        $dir->close();
        return true;
    }

    /**
     * 
     * @param type $date
     * @param type $format
     */
    public static function dateFormat($date, $format = 'Y-m-d') {
        return date($format, strtotime($date));
    }

    /**
     * 
     * @param type $filename
     * @return boolean
     */
    public static function deleteFile($filename) {
        if (file_exists($filename) && !is_dir($filename)) {
            return unlink($filename);
        }
        return false;
    }

    public static function getFileExtension($filename) {
        $file = explode('.', $filename);
        $ext = end($file);
        return strtolower($ext);
    }

}
