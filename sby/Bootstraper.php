<?php

/*
 * 
 */

//only load php file
spl_autoload_extensions(".php");

//this is a magical method to auto load php class without include file
spl_autoload_register();

define('DIR_PATH',  '././'. BASE_APP);

//config folder
define('CONFIG_PATH', DIR_PATH.'/config/');

/*
 * controller base path
 */
define('CONTROLLERS_PATH', DIR_PATH.'/controllers/');

/*
 * models folder
 */
define('MODELS_PATH', BASE_APP.'/models/');
/*
 * views files folder
 */
define('VIEWS_PATH', BASE_APP.'/views/');

//import sby namespace
use sby\core as core;

$sby = new core\Sby();

?>
