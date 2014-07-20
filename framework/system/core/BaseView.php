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
use system\helper\Utils;

class BaseView {

    /**
     * store variable
     * @access private
     * @var array
     */
    private $vars = array();

    /**
     * directory of view files
     * @var string 
     */
    private $viewPath = VIEWS_PATH;

    /**
     * script file
     * @var array 
     */
    public static $scriptFile = array();

    /**
     * style file
     * @var array 
     */
    public static $styleFile = array();

    /**
     * style
     * @var array 
     */
    public static $style = array();

    /**
     * script
     * @var array 
     */
    public static $script = array();

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
     * set view directory
     * @param string $path
     */
    public function setViewDir($path) {
        $this->viewPath = $path;
    }

    /**
     * get layout
     */
    public function setLayout() {
        echo $this->outputHtml($this->layout);
    }

    /**
     * display file
     * @param string $file
     * @param array $data
     */
    public function display($file, $data = array()) {
        $this->content = $this->outputHtml($file, $data);
        $this->setLayout();
    }

    /**
     * generate json output
     * @param type $data
     * @param type $options
     * @param type $depth
     * @return type
     */
    public function outputJson($data, $options = 0, $depth = 512) {
        return json_encode($data, $options);
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

    /**
     * redirect
     * @param string $url
     */
    public function redirect($url) {
        Base::instance()->router->redirect($url);
    }

    /**
     * add base_url if there is no http prefix
     * @param string $url
     * @return string
     */
    public static function checkUrl($url) {
        if ($url and strpos($url, "://") == false) {
            $url = Base::instance()->base_url . $url;
        }
        return $url;
    }

    /**
     * enqueue javascript file
     * @param string $href
     */
    public static function enqueueScriptFile($href) {
        $href = self::checkUrl($href);
        self::$scriptFile[] = "<script src=\"" . $href . "\" type=\"text/javascript\"></script>";
    }

    /**
     * enqueue css file
     * @param string $href
     * @param string $option
     */
    public static function enqueueStyleFile($href, $option = '') {
        $href = self::checkUrl($href);
        self::$styleFile[] = "<link rel=\"stylesheet\" href=\"" . $href . "\" media=\"screen\" $option>";
    }

    /**
     * enqueue css style
     * @param string $style
     */
    public static function enqueueStyle($style) {
        self::$style[] = $style;
    }

    /**
     * enqueue javacript
     * @param string $script
     */
    public static function enqueueScript($script) {
        self::$script[] = $script;
    }

    /**
     * register javascript file and copy it to the assest folder
     * @param string $fileName
     */
    public static function registerScriptFile($fileName) {
        if (ENVIRONMENT == 'development') {
            $dest = DIR_APP . "/assets/js/";
            Utils::xcopy($fileName, $dest);
        }
    }

    /**
     * register css file and copy it to the assest folder
     * @param string $fileName
     */
    public static function registerStyleFile($fileName) {
        if (ENVIRONMENT == 'development') {
            $dest = DIR_APP . "/assets/css/";
            Utils::xcopy($fileName, $dest);
        }
    }

}
