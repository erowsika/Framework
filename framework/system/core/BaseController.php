<?php

namespace system\core;

/**
 * Description of BaseController
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
class BaseController extends BaseView {

    protected $layout = "layout\main.php";
    private $buffer;
    private $isCache;
    private $cacheName;

    public function __construct() {
        parent::__construct();
        ob_start();
        $this->checkAccess();
        $this->isCache = false;
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

    /**
     * 
     * @param type $name
     * @param type $arguments
     */
    public function __call($name, $arguments) {
        // echo $name . ' dsds ' . $arguments;
    }

    /**
     * start cache
     */
    public function startCache() {
        $this->isCache = true;
        $this->cacheName = Base::instance()->router->getController() . '_' . Base::instance()->router->getMethod();
        if (($output = Base::instance()->cache->get($this->cacheName))) {
            echo $output;
            exit();
        }
    }

    /**
     * get the output buffer
     * @return string
     */
    public function getOutputBuffer() {
        return ob_get_clean();
    }

    /**
     * 
     */
    public function __destruct() {
        $this->buffer = $this->getOutputBuffer();

        if ($this->isCache) {
            Base::instance()->cache->set($this->cacheName, $this->buffer);
        }
        echo $this->buffer;
    }

    /**
     * 
     * @return boolean
     */
    public function checkAccess() {
        $method = Base::instance()->router->getMethod();
        $auth = null;
        if (method_exists($this, 'access')) {
            $auth = Base::instance()->auth;
            $access = $this->access();
            foreach ($access as $rule) {
                $executes = $rule['executes'];

                $userRole = isset($rule['user']) ? $rule['user'] : $rule['role'];

                $userAuth = isset($rule['user']) ? $auth->getUser() : $auth->getRole();

                if (in_array($method, $executes)) {
                    $accessType = reset($rule);
                    $hasAuth = in_array($userAuth, $userRole);
                    if ($accessType == 'grant' and $hasAuth) {
                        return true;
                    } else if ($accessType == 'revoke' and $hasAuth) {
                        throw new HttpException('you are not allowed to access this page', 403);
                    }
                }
            }
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
