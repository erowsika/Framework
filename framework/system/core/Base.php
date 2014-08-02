<?php

/**
 * Description of Sby
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class Base {
    /*
     * this variable store the instance of the sby class
     * @var Sby
     * @access private
     */

    private static $_instance;
    
    public $config;

    /**
     * load these automatically class at runtime
     */
    private $classes = array(
        'router' => 'system\core\Router',
        'input' => 'system\core\Input',
        'db' => 'system\db\Database',
        'cache' => 'system\cache\Cache',
        'session' => 'system\helper\Session',
        'cookie' => 'system\helper\Cookie',
        'html' => 'system\helper\Html',
        'ajax' => 'system\helper\Ajax');

    /* this is a constructor
     * @access public
     * 
     */

    public function __construct() {

        // assign config string to this member
        $this->config = Config::getInstance();
        $conf = $this->config->getProperty();
        foreach ($conf as $key => $value) {
            if (!is_array($value)) {
                $this->$key = $value;
            }
        }

        //merge core class with moduls class
        $moduls = $this->config->get('moduls');
        /*  $diff = array_intersect_key($moduls, $this->classes);
          if (!empty($diff)) {
          $sameclass = implode(', ', array_keys($diff));
          throw new MainException("please use the different alias for moduls  $sameclass");
          } */
        $this->classes = array_merge($this->classes, $moduls);

        set_exception_handler('system\core\MainException::handleException');
        set_error_handler('system\core\MainException::handleError', error_reporting());

        register_shutdown_function(array($this, 'shutDown'));
    }

    /**
     *  get instance (Singleton)
     * @access public
     * */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new Base();
        }
        return self::$_instance;
    }

    /**
     * for lazy loader mechanism
     * @param type $name
     * @return type
     * @throws MainException
     */
    public function __get($name) {
        $registry = Registry::getInstance();
        if (!$registry->get($name)) {
            if (isset($this->classes[$name])) {
                $object = new $this->classes[$name]();
                $registry->set($name, $object);
            } else
                throw new MainException("undefined property $name");
        }
        return $registry->get($name);
    }

    /**
     * shutdown
     */
    public function shutDown() {
        $objects = Registry::getInstance()->getProperty();
        foreach ($objects as $key => $object) {
            if (is_object($object) and method_exists($object, '__destruct')) {
                $object->__destruct();
            }
        }
    }

    /**
     * import class file
     * @param string $class
     * @throws MainException
     */
    public static function import($class) {
        if (file_exists($class)) {
            require_once $class;
        } else {
            throw new MainException("file $class not found");
        }
    }

    /**
     * run execution
     * @return void
     */
    public static function invoke($class, $method, $parameters = array()) {
        if (method_exists($class, $method)) {
            return call_user_func_array(array(&$class, $method), $parameters);
        }
    }

    /*
     * run application
     * @return void
     */

    public function run() {

        $namespace = APP_NAME . '\\controllers\\';
        $controller = $this->router->getController();

        if (strpos($controller, $namespace) === FALSE) {
            $controller = $namespace . $controller;
        }
        $method = $this->router->getAction();
        $parameters = $this->router->getParameter();
        
        try {
            if (class_exists($controller, true)) {
                $this->$controller = new $controller();
                $this->runController($controller, $method, $parameters);
            } else {
                throw new HttpException('Page not found', 404);
            }
        } catch (HttpException $e) {
            $e->printError();
        }
    }

    /**
     * run controller
     * @param type $controller
     * @param type $method
     * @param type $parameters
     * @throws HttpException
     */
    private function runController($controller, $method, $parameters) {
        if (in_array($method, get_class_methods($this->$controller))) {
            self::invoke($this->$controller, "beforeExecute");
            self::invoke($this->$controller, $method, $parameters);
            self::invoke($this->$controller, "afterExecute");
        } else {
            throw new HttpException('Page not found', 404);
        }
    }

}

?>
