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

}
