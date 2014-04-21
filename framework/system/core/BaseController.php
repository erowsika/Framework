<?php

namespace system\core;

/**
 * Description of BaseController
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
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
        if (parent::__get($name)) {
            return parent::__get($name);
        } else if (Base::instance()->$name) {
            return Base::instance()->$name;
        } else
            return $value;
    }

    public function __call($name, $arguments) {
        echo $name . ' dsds ' . $arguments;
    }

    private function checkPermision() {
        
    }

    private function isCaching() {
        if (method_exists($this, 'permission')) {
            
        }
    }

    public function beforeExecute() {
        
    }

    public function afterExecute() {
        
    }

}
