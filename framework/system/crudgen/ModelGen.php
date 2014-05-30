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

class ModelGen extends BaseView {

    public $layout = 'main.php';
    private $table;
    private $primary_key;
    private $controller;
    private $model;
    private $model_class;
    private $view_dir;

    public function __construct() {
        $this->table = Base::instance()->input->get('table');
        $this->setViewDir(__DIR__ . '/layout/');
        $this->initTable();
        $this->controller = Base::instance()->input->get('controller');
        $this->model = $this->table;
        $this->model_class = Base::instance()->input->get('model');
        $this->view_dir = $this->table;
    }

    public function initTable() {
        $db = Base::instance()->db->getConnection();
        $cols = $db->columns($this->table);
        foreach ($cols as $key => $value) {
            if ($value['pk']) {
                $this->primary_key = $value['name'];
            }
        }
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
        $db = Base::instance()->db->getConnection();
        $this->columns = $db->columns($this->table);
        echo $this->display('model/index.php');
    }

}
