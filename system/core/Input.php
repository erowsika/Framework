<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\core;

/**
 * Description of Input
 *
 * @author masfu
 */
class Input {

    
    /**
     * 
     * @param type $key
     * @param type $xss_clean
     * @return type
     */
    
    public function cookie($key = null, $xss_clean = false) {
        $value = $_COOKIE;
        return $this->filter($value, $key, $xss_clean);
    }
    /**
     * get input data from $_POST variable
     * @param string $key
     * @param boolean $xss_clean
     * @return string
     */
    public function post($key = null, $xss_clean = false) {
        $value = $_POST;
        return $this->filter($value, $key, $xss_clean);
    }

    /**
     * get input data form $_GET variable
     * @param string $key
     * @param boolean $xss_clean
     * @return string
     * 
     */
    public function get($key = "", $xss_clean = false) {
        $value = $_GET;
        return $this->filter($value, $key, $xss_clean);
    }

    /**
     * filter data
     * @param array $data
     * @param type $xss_clean
     * @return string
     * 
     */
    public function filter($data, $key, $xss_clean) {
        if (!empty($key) and isset($data[$key])) {

            $value = $data[$key];

            if (is_array($value)) {
                $arrdata = array();
                foreach ($value as $key => $str) {
                    $arrdata[$key] = $this->escapeStr($str, $xss_filter);
                }
                return $arrdata;
            }
            return $value;
        }
    }

    /**
     * escape string data
     * @param string $str
     * @param boolean $xss_filter
     * @return string
     * 
     */
    public function escapeStr($str, $xss_filter = false) {
        $str = remove_invisible_characters($str);
        $str = addslashes($str);
        return ($xss_filter) ? $this->xssClean($str) : $str;
    }

    /**
     * remove dangerous string
     * @param string $val
     * @return string
     */
    public function xssClean($val) {
        $val = htmlentities($val);
        $val = strip_tags($val);
        $val = filter_var($val, FILTER_SANITIZE_STRING);
        return $val;
    }

}
