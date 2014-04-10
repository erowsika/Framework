<?php

/**
 * Description of View
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
//only load php file

define('EXT_FILE', '.php');

//base path
define('SYS_PATH', '.././' . BASE_APP);

//config folder
define('CONFIG_PATH', SYS_PATH . '/config/');

/*
 * controller base path
 */
define('CONTROLLERS_PATH', SYS_PATH . '/controllers/');

/*
 * models folder
 */
define('MODELS_PATH', SYS_PATH . '/models/');
/*
 * views files folder
 */
define('VIEWS_PATH', SYS_PATH . '/views/');


spl_autoload_extensions(".php");

//this is a magical method to auto load php class without include file
spl_autoload_register(function($class) {
    $filename = $class . '.php';

    if (file_exists(__DIR__ . '\\' . $class . '.php')) {
        require_once __DIR__ . '\\' . $class . '.php';
    } else if (file_exists(SYS_PATH . '\\' . $class . '.php')) {
        require_once SYS_PATH . '\\' . $class . '.php';
    }
});

//set_exception_handler('core\MainException::handler');
//set_error_handler('core\MainException::errorCallback', error_reporting());

//import sby namespace
use core as base;

class Sby extends base\Base {
    
}

$sby = Sby::getInstance();

$sby->run();
?>
