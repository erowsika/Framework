<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\core;

/**
 * Description of BaseView
 *
 * @author masfu
 */
use system\core\MainException;

class BaseView {

    /**
     * store variable
     * @access private
     * @var array
     */
    private $vars = array();
    private $viewPath = VIEWS_PATH;
    private $buffer;
    private $_isCache;
    private $cacheName;

    public function __construct() {
        $this->_isCache = false;
        ob_start();
    }

    /**
     * get store value
     * @param string $name
     * @return string
     * 
     */
    public function __get($name) {
        return isset($this->vars[$name]) ? $this->vars[$name] : null;
    }

    /**
     * 
     * @param type $name
     * @param type $value
     * @throws MainException
     */
    public function __set($name, $value) {
        if ($name == 'view_template_file') {
            throw new MainException("Cannot bind variable named '$view_template_file'");
        }
        $this->vars[$name] = $value;
    }

    /**
     * assign data to this object
     * @param type $name
     * @param type $value
     */
    public function assign($name, $value) {
        $this->_set($name, $value);
    }

    /**
     * print html to browser
     * @param type $file
     * @param type $vars
     * @return type
     * @throws MainException
     */
    public function outputHtml($file, $vars = null) {

        if (is_array($vars)) {
            $this->vars = array_merge($this->vars, $vars);
        }

        try {
            $file = $this->viewPath . str_ireplace('\\', '/', $file);

            if (!file_exists($file)) {
                throw new MainException("File {$file} not found");
            }
 
            extract($this->vars);
            ob_start();
            include($file);
            return ob_get_clean();
        } catch (MainException $e) {
            $e->toString();
        }
    }

    /**
     * 
     * @param type $path
     */
    public function setViewDir($path) {
        $this->viewPath = $path;
    }

    /**
     * 
     */
    public function setLayout() {
        echo $this->outputHtml($this->layout);
    }

    /**
     * 
     * @param type $file
     * @param type $data
     */
    public function display($file, $data = array()) {
        $this->content = $this->outputHtml($file, $data);
        $this->setLayout();
    }

    /**
     * start cache
     */
    public function startCache() {
        $this->_isCache = true;
        $this->cacheName = $this->router->getController() . '_' . Base::instance()->router->getMethod();
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

        if ($this->_isCache) {
            Base::instance()->cache->set($this->cacheName, $this->buffer);
        }
        echo $this->buffer;
    }

    /**
     * generate json output
     * @param type $data
     * @param type $options
     * @param type $depth
     * @return type
     */
    public function outputJson($data, $options = 0, $depth = 512) {
        return json_encode($data, $options, $depth);
    }

    /**
     * write xml
     * http://www.viper007bond.com/2011/06/29/easily-create-xml-in-php-using-a-data-array/
     * @return boolean
     */
    public function outputXml($data) {
        if (empty($data['name']))
            return false;

        // Create the element
        $element_value = (!empty($data['value']) ) ? $data['value'] : null;
        $element = $dom->createElement($data['name'], $element_value);

        // Add any attributes
        if (!empty($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $attribute_key => $attribute_value) {
                $element->setAttribute($attribute_key, $attribute_value);
            }
        }

        // Any other items in the data array should be child elements
        foreach ($data as $data_key => $child_data) {
            if (!is_numeric($data_key))
                continue;

            $child = generate_xml_element($dom, $child_data);
            if ($child)
                $element->appendChild($child);
        }

        return $element;
    }

    public function redirect($url) {
        Base::instance()->router->redirect($url);
    }

}
