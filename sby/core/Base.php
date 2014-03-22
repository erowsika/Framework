<?php

/**
 * Description of Sby
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace core;

class Base {
    /*
     * this variable store the instance of the sby class
     * @var Sby
     * @access private
     */

    private static $_instance;

    /* varible registry
     * @var Registry
     */
    private $_config;

    /*
     * load these automatically class at runtime
     */
    private $classes = array('Config' => 'core\Config',
        'Router' => 'core\Router',
        'Logger' => 'core\Logger');

    /* this is a constructor
     * @access public
     * 
     */

    public function __construct() {
        $this->initClass();
        $this->initConfig();
    }

    /* get instance (Singleton)
     * 
     */

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Base();
        }
        return self::$_instance;
    }

    /*
     * initialization config file
     */

    private function initConfig() {
        $conf = $this->config->get();
        foreach ($conf as $key => $value) {
            if (!is_array($value)) {
                $this->$key = $value;
            }
        }
    }

    /*
     * load all classes that predifined before
     * @access private
     * @param void
     * @return void
     */

    private function initClass() {

        foreach ($this->classes as $className => $class) {

            $className = strtolower($className);
            $this->$className = new $class();
        }
    }

    /*
     * run application
     * @return void
     */

    public function run() {

        $controller = '\\controllers\\' . $this->router->getController();
        $method = $this->router->getMethod();
        $parameters = $this->router->getParameter();
        
        $classController = new $controller();
        
        if (isset($method) AND in_array($method, get_class_methods($classController))) {
            call_user_func_array(array(&$classController, $method), $parameters);
        } else {
           new HttpException("404", 'Halaman tidak ditemukan');
        }
    }

}

?>
