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

    public function __construct() {
        parent::__construct();
        $this->checkAccess();
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
                        $this->outputJson(array("you don't have any such privileges to access this page"));
                        Base::instance()->input->response($this->output, "application/json", 403);
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
