<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Service
 *
 * @author masfu
 */
use system\core\BaseView;
use system\core\Base;

class Ajax extends BaseView {

    public function call($url, $successCallback) {
        $jsfunc = $this->convertUrlToMethod($url);
        $url = $this->getFullUrl($url);
        self::enqueueScript(
                <<<SCRIPT
        function $jsfunc(){        
            $.ajax({url:'$url',success:function(result){
                $successCallback(result);
            }});
        }
SCRIPT
        );
        return $jsfunc . '()';
    }

    public function get() {
        
    }

    public function load($selector, $url) {
        
    }

    public function post() {
        
    }

    public function getScript() {
        
    }

    public function getJson() {
        
    }

    public function getHtml() {
        
    }

    public function ajaxStart() {
        
    }

    public function ajaxComplete() {
        
    }

    public function ajaxStop() {
        
    }

    public function ajaxError() {
        
    }

    public function ajaxSuccess() {
        
    }

    private function getFullUrl($url) {
        if ($url and strpos($url, "://") == false) {
            $url = Base::instance()->base_url . $url;
        }
        return $url;
    }
    
    private function convertUrlToMethod($url){
        return str_replace('/', '', $url);
    }

}
