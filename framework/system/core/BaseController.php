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
        parent::__construct();
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
            throw new MainException("$name doesnt exist");
    }

    public function __call($name, $arguments) {
        // echo $name . ' dsds ' . $arguments;
    }

    public function permission() {
        if (method_exists($this, 'access')) {
            
        }
    }
    
    /**
     * 
     * @param string $url
     */
    public function redirect($url) {
        if ($url and strpos($url, "://") == false)
            $url = Base::instance()->base_url . $url;
        header("Location: " . $url);
    }

    /**
     * 
     */
    public function beforeExecute() {
        
    }

    /**
     * 
     */
    public function afterExecute() {
        
    }

}
