<?php

//include 'init.php';
/**
 * define application name
 */
define('APP_NAME', 'app');

/**
 * define application directory
 */
define('DIR_APP', __DIR__);


//base path
define('APP_PATH', DIR_APP .DIRECTORY_SEPARATOR. APP_NAME);

//config folder
define('CACHE_PATH', APP_PATH . '/cache/');

//config folder
define('CONFIG_PATH', APP_PATH . '/config/');

/**
 * controller path
 */
define('CONTROLLER_PATH', APP_PATH . '/controller/');

/*
 * models folder
 */
define('MODELS_PATH', APP_PATH . '/models/');
/*
 * views files folder
 */
define('VIEWS_PATH', APP_PATH . '/views/');
/*
 * logs files folder
 */
define('LOGS_PATH', APP_PATH . '/logs/');

/*
 * error files folder
 */
define('ERROR_PATH', APP_PATH . '/errors/');

/**
 * include bootsrap file
 */
require_once '../framework/system/Bootstraper.php';

/**
 * run the application
 */
Sby::instance()->run();
?>
