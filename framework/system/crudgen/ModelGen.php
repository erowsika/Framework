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
    private $attributes = array();

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
            $this->attributes[] = $value['name'];
        }
    }

    public function make() {
        $rules = "";
        foreach ($this->attributes as $key => $value) {

            $col = Base::instance()->input->post('col_' . $value);

            if ($col != "") {
                $label = Base::instance()->input->post('label_' . $value);
                $type = Base::instance()->input->post('type_' . $value);
                $required = Base::instance()->input->post('required_' . $value) ? 'true' : 'false';
                $min = Base::instance()->input->post('min_' . $value);
                $max = Base::instance()->input->post('max_' . $value);
                $trim = Base::instance()->input->post('trim_' . $value) ? 'true' : 'false';

                $rules .= "
                         array(
                            'label' => '$label',
                            'field' => '$col',
                            'rules' => 'type:$type|min:$min|max:$max|required:$required|trim:$trim'),";
            }
        }
        $rules = substr($rules, 0, strlen($rules) - 1);

        $filename = __DIR__ . '/layout/model/template.tpl';
        $template = file_get_contents($filename);

        $template = str_replace('{model_class}', $this->model_class, $template);
        $template = str_replace('{table}', $this->table, $template);
        $template = str_replace('{rules}', $rules, $template);

        return $template;
    }

    private function write() {
        $template = $this->make();
        $filename = MODELS_PATH . $this->model_class . EXT_FILE;
        $this->status = $filename;
        file_put_contents($filename, $template);
        return trim(htmlentities($template));
    }

    private function download() {
        $template = $this->make();
        $filename = MODELS_PATH . $this->model_class . EXT_FILE;
        $this->code = trim(htmlentities($template));
        file_put_contents($filename, $template);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
    }

    public function run() {
        $action = Base::instance()->input->post('action');
        $this->code = '';
        switch ($action) {
            case 'write_file':
                $this->code = $this->write();
                break;
            case 'download' :
                $this->download();
                exit();
            default:
                break;
        }
        $db = Base::instance()->db->getConnection();
        $this->columns = $db->columns($this->table);
        echo $this->display('model/index.php');
    }

}
