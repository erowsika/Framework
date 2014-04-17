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
class BaseView {

    /**
     * store variable
     * @access private
     * @var array
     */
    private $vars = array();

    /**
     * get store value
     * @param string $name
     * @return string
     * 
     */
    public function __get($name) {
        return $this->vars[$name];
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

    public function assign($name, $value) {
        $this->_set($name, $value);
    }

    public function outputHtml($view_template_file, $vars = null) {
        if (array_key_exists('view_template_file', $this->vars)) {
            throw new MainException("Cannot bind variable called '$view_template_file'");
        }

        if (is_array($vars)) {
            $this->vars = $vars;
        }

        try {
            $file = DIR_APP . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . str_ireplace('\\', '/', $view_template_file);
            
            if (!file_exists($file)) {
                throw new MainException("File {$file} not found");
            }
            
            extract($this->vars);
            ob_start();
            include($file);
            return ob_get_clean();
        } catch (\system\core\MainException $e) {
            $e->toString();
        }
    }

}
