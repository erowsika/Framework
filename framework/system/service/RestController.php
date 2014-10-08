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
use system\core\Input;

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
    private $output = '';

    /**
     *
     * @var type 
     */
    private $httpStatus = 200;

    /**
     * public constructor
     */
    public function __construct() {
        $this->checkAccess();
    }

    /**
     * overide method outputXML
     * @param string $data
     * @param string $options
     * @param string $depth
     */
    public function outputXml($data) {
        $contentType = "application/xml";
        $this->output = parent::outputXml($data);
    }

    /**
     * set data
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        parent::__set($name, $value);
    }

    /**
     * get data
     * @param string $name
     * @return object 
     */
    public function __get($name) {
        if (parent::__get($name)) {
            return parent::__get($name);
        } else if (Base::instance()->$name) {
            return Base::instance()->$name;
        } else {
            throw new MainException("$name doesnt exist");
        }
    }

    /**
     * 
     */
    final public function index() {
        $method = $this->input->getMethod();
        $parameters = $this->router->getParameter();
        $class = get_called_class();

        $matches = preg_grep("/(" . strtolower($method) . ")/i", get_class_methods($class));

        if (count($matches) > 0) {
            $action = reset($matches);
            $this->output = call_user_func_array(array(&$this, $action), $parameters);
        } else {
            $this->output = array(
                'success' => false,
                'message' => "server error, method does not implemented "
            );
        }
    }

    /**
     * 
     */
    private function checkAccess() {
        if (!method_exists($this, $this->router->getAction())) {
            $this->output = array(
                'success' => false,
                'message' => "server error, method does not implemented "
            );
            die;
        }
    }

    public function setHttpStatus($code) {
        $this->httpStatus = $code;
    }

    /**
     * 
     * @param type $output
     */
    protected function setOutput($output, $code = 200) {
        $this->output = $output;
        $this->httpStatus = $code;
    }

    /**
     * 
     */
    public function __destruct() {
        $response = $this->outputJson($this->output);
        $response = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $response);
        $this->input->response($response, "application/json", $this->httpStatus);
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
