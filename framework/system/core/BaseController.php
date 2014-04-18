<?php

/**
 * Description of BaseController
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class BaseController extends BaseView {
    
    
    public function __construct() {
        
    }

        /**
     * 
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        parent::__set($name, $value);
    }

    /**
     * 
     * @param string $name
     * @return object 
     */
    public function __get($name) {
        if (($value = parent::__get($name))) {
            return $value;
        } else if (isset(\Sby::instance()->$name)) {
            return \Sby::instance()->$name;
        } else
            return $value;
    }

}
