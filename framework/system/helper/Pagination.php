<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Pagination
 *
 * @author masfu
 */
class Pagination {

    public $baseUrl;
    public $total;
    public $limit;
    public $current;
    public $query = 'page';
    public $prevText = '<li><a href="#">&laquo;</a></li>';
    public $nextText = '<li><a href="#">&raquo;</a></li>';
    public $styleListActive = '<li class="active"><a href="#">{page}</a><li>';
    public $styleList = '<li><a href="{page}">{num}</a><li>';

    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {
        if (!empty($config)) {
            $this->set($config);
        }
    }

    /**
     * 
     * @param type $var
     * @param type $value
     */
    public function set($var, $value = false) {
        if (is_string($var)) {
            $this->$var = $value;
        }

        if (is_array($var)) {

            foreach ($var as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function render() {
        $total = ceil($this->total / $this->limit);

        //$total += $this->current;
        $start = 1;

        if ($this->current > 1) {
            $start = abs($total - $this->limit);
        }
        
        $urlCallback = $this->baseUrl . "/?" . $this->query . "=";
        $output = str_replace("#", $urlCallback . $start, $this->prevText);
        
        for ($i = $this->current + 1; $i <= $total; $i++) {
            
            if ($i > $this->total)
                break;
            
            if ($i == $this->current) {
                $output .= str_replace("{page}", $i, $this->styleListActive);
            } else {
                $page = str_replace("{page}", $urlCallback . $i, $this->styleList);
                $page = str_replace("{num}", $i, $page);
                $output .= $page;
            }
        }
        $end = ($total >= $this->total) ? $total : $total + 1;
        $output .= str_replace("#", $urlCallback . $end, $this->nextText);
        return $output;
    }

}
