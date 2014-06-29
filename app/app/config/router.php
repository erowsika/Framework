<?php

return array(
    /**
     * default controller
     */
    'default_controller' => 'Welcome',
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
