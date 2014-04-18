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

    /*
     * load these automatically class at runtime
     */
    private $classes = array('config' => 'system\core\Config',
        'router' => 'system\core\Router',
        'input' => 'system\core\Input',
        'db' => 'system\db\SqlProvider');

    /* this is a constructor
     * @access public
     * 
     */

    public function __construct() {
        $this->initClass();
        $this->initConfig();
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

                $class = new $controller();

                if (in_array($method, get_class_methods($class))) {

                    $this->dispatch($class, "beforeExecute");

                    $this->dispatch($class, $method, $parameters);

                    $this->dispatch($class, "afterExecute");
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
