<?php

/**
 * Description of View
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
//only load php file

define('EXT_FILE', '.php');

define('SYS_NAME', 'system');

//base path
define('SYS_PATH', DIR_APP);

//config folder
define('CONFIG_PATH', SYS_PATH . '/config/');

/*
 * models folder
 */
define('MODELS_PATH', SYS_PATH . '/models/');
/*
 * views files folder
 */
define('VIEWS_PATH', SYS_PATH . '/views/');


/*
 * logs files folder
 */
define('LOGS_PATH', SYS_PATH . '/logs/');


spl_autoload_extensions(".php");

//this is a magical method to auto load php class without include file
spl_autoload_register(function($class) {
    $filename = $class . EXT_FILE;
    if (file_exists(str_replace(SYS_NAME, '', __DIR__) . $filename)) {
        $dir = str_replace(SYS_NAME, '', __DIR__);
        require_once $dir . '\\' . $filename;
    } else if (file_exists(DIR_APP . '\\' . $filename)) {
        require_once DIR_APP . '\\' . $filename;
    }
});

//set_exception_handler('core\MainException::handler');
//set_error_handler('core\MainException::errorCallback', error_reporting());


use system\core as core;

class Sby extends core\Base {
    
}

?>
