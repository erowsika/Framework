<?php

return array(
    'base_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'ti' => 'Aplikasi n Teknologi Web',
    /*
     * base url for domain and path 
     */
    'base_url' => 'http://localhost/framework/admin/',
    /* default router where the default class and action should be called
     * controller is a class name
     * action is a function name
     * 
     */
    'router' => array(
        'controller' => 'welcome',
        'parameter' => array(
        )),
    /*
     * modules is an autoload mechanism
     */
    'modules' => array(),
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
            'database' => 'bts',
            'username' => 'root',
            'password' => '1234',
            'port' => '3306',
            'autoinit' => true,
            'charset' => 'utf8',
            'prefix' => '',
        ),
    /*
              'sqlite' => array(
              'driver' => 'sqlite',
              'database' => 'application',
              'prefix' => '',
              ),
              'oracle' => array(
              'driver' => 'oracle',
              'connection_string' => '',
              'username' => '',
              'password' => ''),
              'pgsql' => array(
              'driver' => 'pgsql',
              'host' => 'localhost',
              'database' => 'database',
              'username' => 'root',
              'password' => '',
              'charset' => 'utf8',
              'prefix' => '',
              'schema' => 'public',
              ),
              'sqlsrv' => array(
              'driver' => 'sqlsrv',
              'host' => 'localhost',
              'database' => 'database',
              'username' => 'root',
              'password' => '',
              'prefix' => '',
              ),
              /* second database
             * 
             */
    //"db" => array()
    ),
    'encoding' => 'UTF-8',
    'timezone' => 'UTC'
);

