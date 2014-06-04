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

    public $allow = array();
    public $request = array();

    /**
     * public constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * overide method outputJson
     * @param type $data
     * @param type $options
     * @param type $depth
     */
    public function outputJson($data, $options = 0, $depth = 512) {
        $contentType = "application/json";
        $data = parent::outputJson($data, $options, $depth);
        Base::instance()->input->response($data, $contentType);
    }

    /**
     * overide method outputXML
     * @param type $data
     * @param type $options
     * @param type $depth
     */
    public function outputXml($data) {
        $contentType = "application/xml";
        $data = parent::outputXml($data);
        Base::instance()->input->response($data, $contentType);
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
        if (method_exists($this, 'access')) {
            
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
