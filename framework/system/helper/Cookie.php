<<<<<<< HEAD
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Cookie
 *
 * @author masfu
 */
use system\core\Base;

class Cookie {

    public $expire = 525600;
    public $path = '/';
    public $domain = '';
    public $secure = false;

    public function __set($name, $value) {
        setcookie($name, $value, $expire, $path, $domain, $secure);
    }

    public function __get($name) {
        return Base::instance()->input->getCookie($name);
    }

}
=======
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Cookie
 *
 * @author masfu
 */
use system\core\Base;

class Cookie {

    public $expire = 525600;
    public $path = '/';
    public $domain = '';
    public $secure = false;

    public function __set($name, $value) {
        setcookie($name, $value, $expire, $path, $domain, $secure);
    }

    public function __get($name) {
        return Base::instance()->input->cookie($name);
    }

}
>>>>>>> b712582a47ecad6b4a21913d50954f94eea2aac0
