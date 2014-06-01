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

class ControllerGen extends Generator {

    public function __construct() {
        parent::__construct();
    }

        public function make() {
        $filename = __DIR__ . '/layout/controller/template.tpl';
        $template = file_get_contents($filename);

        $template = str_replace('{controller}', $this->controller, $template);
        $template = str_replace('{model}', $this->model, $template);
        $template = str_replace('{model_class}', $this->model_class, $template);
        $template = str_replace('{view_dir}', $this->view_dir, $template);
        $template = str_replace('{primary_key}', $this->primary_key, $template);

        return $template;
    }

    public function run() {
        $code = $this->make();
        $action = Base::instance()->input->post('action');
        switch ($action) {
            case 'write_file':
                $filename = CONTROLLER_PATH . $this->controller . EXT_FILE;
                $this->write($filename, $code);
                break;
            case 'download' :
                $code = $this->make();
                $filename = CONTROLLER_PATH . $this->controller . EXT_FILE;
                $this->download($filename, $code);
                exit();
            default:
                break;
        }
        $db = Base::instance()->db->getConnection();
        $this->view->columns = $db->columns($this->table);
        $this->view->code = htmlentities($code);
        echo $this->view->display('controller/index.php');
    }

}
