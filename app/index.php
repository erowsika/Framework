<?php

define('APP_NAME', str_replace(dirname(__DIR__).DIRECTORY_SEPARATOR, '', dirname(__FILE__)));

define('DIR_APP', dirname(__DIR__).DIRECTORY_SEPARATOR);

require_once '../framework/system/Bootstraper.php';

Sby::instance()->run();

?>
