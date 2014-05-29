<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\crudgen;

/**
 * Description of ControllerGen
 *
 * @author masfu
 */
use system\core\Base;
use system\core\BaseView;

class ControllerGen extends BaseView {

    private $table;
    public $layout = 'main.php';

    public function __construct() {
        $this->table = Base::instance()->input->get('table');
        $this->setViewDir(__DIR__ . '/layout/');
    }

    public function generate() {
        
    }

    public function run() {
        echo $this->display('controller/index.php');
    }

}
