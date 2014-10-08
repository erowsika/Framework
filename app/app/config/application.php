<?php

return array(
    'base_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'title' => 'Framework baru',
    /*
     * base url for domain and path 
     */
    'base_url' => 'http://hisyam-pc/framework/app/',
    /*
     * modules is an autoload mechanism
     */
    'moduls' => array('auth' => 'app\core\Auth'),
    'router' => array(
        /**
         * default controller
         */
        'default_controller' => 'Welcome',
        /**
         * add suffix at the end of controller class
         */
        'controller_suffix' => 'Controller',
        /**
         * parameter of url pattern
         */
        'parameter' => array(
            'controller' => '(\w+)',
            'action' => '(\w+)',
            'id' => '(\d+)',
            'page' => '(\d+)'
        )
    ),
    /*
     * database configuration
     * we can use multiple database connection at same time
     */
    'database' => array(
        /*
         * the first database configuration
         */
        'mysql' => array(
            'driver' => 'mysqli',
            'host' => 'localhost',
            'database' => 'posyandu',
            'username' => 'root',
            'password' => '1234',
            'port' => '3306',
            'persistent' => false,
            'autoinit' => true,
        ),
        'pgsql' => array(
            'driver' => 'pgsql',
            'host' => 'localhost',
            'database' => 'hr',
            'username' => 'postgres',
            'password' => '1234',
            'persistent' => false,
            'autoinit' => true,
        ),
        'pdo' => array(
            'driver' => 'pdo',
            'dsn' => 'sqlite:/mydb.sq3',
            'username' => 'postgres',
            'password' => '1234',
            'persistent' => false,
            'autoinit' => true,
        ),
        'oci' => array(
            'driver' => 'oci',
            'dsn' => 'orcl',
            'username' => 'hr',
            'password' => 'hr',
            'port' => '1521',
            'persistent' => false,
            'autoinit' => true,
        ),
        'mongo' => array(
            'driver' => 'mongodb',
            'document' => 'test',
            'host' => 'localhost',
            'username' => '',
            'password' => '',
            'autoinit' => true,
        ),
    ),
    'encoding' => 'UTF-8',
    /**
     * set time zone
     */
    'timezone' => 'UTC',
    /**
     * set session name
     */
    'session' => array(
        'login_url' => '',
        /**
         * set session name
         */
        'session_name' => 'framework',
        /**
         * session time expiration
         * default 2 weeks
         */
        'session_expire' => 3600 * 24 * 14),
    'cache' => array('driver' => 'file')
);

