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

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        break;

    case 'testing':
    case 'production':
        error_reporting(0);
        break;

    default:
        exit('The application environment is not set correctly.');
}

spl_autoload_extensions(".php");

//this is a magical method to auto load php class without include file
spl_autoload_register(function($class) {

    try {
        $filename = DIRECTORY_SEPARATOR . str_ireplace('\\', '/', $class) . EXT_FILE;
        $dir = strpos($filename, SYS_NAME) ? str_replace(SYS_NAME, '', __DIR__) : DIR_APP;
        $file = $dir . $filename;
        
        if (!file_exists($file)) {
            throw new \Exception("Unable to load $filename file not found");
        }
        
        require $file;
    } catch (\Exception $e) {
        
    }
});

use system\core as core;

class App extends core\Base {
    
}

?>
