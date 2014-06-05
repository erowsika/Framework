<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\service;

/**
 * Description of RestController
 *
 * @author masfu
 */
use system\core\BaseView;
use system\core\Base;

class RestController extends BaseView {

    /**
     * layout file
     * @var string
     */
    protected $layout = "layout\main.php";

    /**
     *
     * @var output data 
     */
    private $output = array();

    /**
     * public constructor
     */
    public function __construct() {
        parent::__construct();
        $this->checkAccess();
    }

    /**
     * overide method outputJson
     * @param type $data
     * @param type $options
     * @param type $depth
     */
    public function outputJson($data, $options = 0, $depth = 512) {
        $contentType = "application/json";
        $this->output = parent::outputJson($data, $options, $depth);
    }

    /**
     * overide method outputXML
     * @param type $data
     * @param type $options
     * @param type $depth
     */
    public function outputXml($data) {
        $contentType = "application/xml";
        $this->output = parent::outputXml($data);
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

    /**
     * 
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
     */
    public function beforeExecute() {
        
    }

    /**
     * 
     */
    public function afterExecute() {
        
    }

}
