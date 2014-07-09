<?php

return array(   
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
);
