<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\core;

/**
 * Description of Session inspiration from code igniter
 *
 * @author masfu
 */
class Session {

    public function __construct() {
        session_start();
    }

    public function get($key){
        
    }
    
    public function setUserData($newdata = array(), $newvalue = '') {
        if (is_array($newdata)) {
            foreach ($newdata as $key => $val) {
                $this->setSession($key, $val);
            }
        } else
            $this->set($newdata, $newvalue);
    }

    public function set() {
        
    }
    
    public function unsetSess(){
        
    }
    
    public function destroy(){
        
    }

}
