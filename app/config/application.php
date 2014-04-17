<?php

return array(
    'base_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'title' => 'Framework baru',
    /*
     * base url for domain and path 
     */
    'base_url' => 'http://localhost/framework/app/',
    /* default router where the default class and action should be called
     * controller is a class name
     * action is a function name
     * 
     */
    'router' => array(
        'controller' => 'welcome',
        'parameter' => array()),
    /*
     * modules is an autoload mechanism
     */
    'modules' => array('Config' => 'core\Config',
        'Router' => 'core\Router',
        'Logger' => 'core\Logger'),
    /*
     * database configuration
     * we can use multiple database connection at same time
     */
    'database' => array(
        /*
         * the first database configuration
         */
        'db' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'mydb',
            'username' => 'root',
            'password' => '1234',
            'port' => '3306',
            'persistent' => false,
            'autoinit' => true,
        ),
    /* second database
     * 
     */
//"db" => array()
    ),
    'encoding' => 'UTF-8',
    'timezone' => 'UTC'
);

