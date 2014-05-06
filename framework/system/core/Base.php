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

    /**
     * load these automatically class at runtime
     */
    private $classes = array(
        'router' => 'system\core\Router',
        'input' => 'system\core\Input',
        'db' => 'system\db\Database',
        'cache' => 'system\cache\Cache',
        'html' => 'system\helper\Html');

    /* this is a constructor
     * @access public
     * 
     */

    public function __construct() {

        // assign config string to this member
        $conf = Config::getInstance()->getProperty();
        foreach ($conf as $key => $value) {
            if (!is_array($value)) {
                $this->$key = $value;
            }
        }

        //merge core class with moduls class
        $moduls = Config::getInstance()->get('moduls');
        $diff = array_intersect_key($moduls, $this->classes);
        if (!empty($diff)) {
            $sameclass = implode(', ', array_keys($diff));
            throw new MainException("please use the different alias for moduls  $sameclass");
        }
        $this->classes = array_merge($this->classes, $moduls);
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

    public function shutDown() {
        $objects = Registry::getInstance()->getProperty();
        foreach ($objects as $key => $object) {
            if (is_object($object) and method_exists($object, '__destruct')) {
                $object->__destruct();
            }
        }
    }

    /**
     * run execution
     * @return void
     */
    private function dispatch($class, $method, $parameters = array()) {
        if (method_exists($class, $method)) {
            call_user_func_array(array(&$class, $method), $parameters);
        }
    }

    /*
     * run application
     * @return void
     */

    public function run() {

        $controller = APP_NAME . '\\controllers\\' . $this->router->getController();
        $method = $this->router->getMethod();
        $parameters = $this->router->getParameter();

        try {
            if (isset($method) and class_exists($controller, true)) {

                $this->$controller = new $controller();

                if (in_array($method, get_class_methods($this->$controller))) {

                    $this->dispatch($this->$controller, "beforeExecute");

                    $this->dispatch($this->$controller, $method, $parameters);

                    $this->dispatch($this->$controller, "afterExecute");
                } else {
                    throw new HttpException('Halaman tidak ditemukan', 404);
                }
            } else {
                throw new HttpException('Halaman tidak ditemukan', 404);
            }
        } catch (HttpException $e) {
            $e->printError();
        }
    }

}

?>
