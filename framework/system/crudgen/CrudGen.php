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

class CrudGen extends Generator {

    public function __construct() {
        parent::__construct();
    }

    public function make() {
        $controller = new ControllerGen();
        $model = new ModelGen();
        $view = new ViewGen();
        $controllerPath = CONTROLLER_PATH . $this->controller . EXT_FILE;
        $modelPath = MODELS_PATH . $this->model_class . EXT_FILE;

        $viewDir = VIEWS_PATH . $this->table;
        if (!is_dir($viewDir)) {
            mkdir($viewDir, 0777);
        }
        $viewPath = $viewDir . '/form' . EXT_FILE;

        $controllerCode = $controller->make();
        $modelCode = $model->make();
        $viewCode = $view->make();


        $controller->write($controllerPath, $controllerCode);
    }

    public function run() {
        $action = Base::instance()->input->post('action');
        switch ($action) {
            case 'write_file':
                $code = $this->make();
                $filename = MODELS_PATH . $this->model_class . EXT_FILE;
                $this->view->code = $this->write($filename, $code);
                break;
            case 'download' :
                $code = $this->make();
                $filename = MODELS_PATH . $this->model_class . EXT_FILE;
                $this->download($filename, $code);
                exit();
            default:
                break;
        }
        $db = Base::instance()->db->getConnection();
        $this->view->columns = $db->columns($this->table);
        echo $this->view->display('crud/index.php');
    }

}
