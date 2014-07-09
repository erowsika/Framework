<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\cache;

/**
 * Description of BaseCache
 *
 * @author masfu
 */
class BaseCache {

    /**
     * config object
     * @var string
     */
    public $config = array();
    
    /**
     * storage type
     * @var string  
     */
    public $storage = "";
    
    /**
     * option
     * @var array 
     */
    public $option = array();
    
    /**
     * path directory
     * @var string 
     */
    public $path = "";

}
