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

class ModelGen extends Generator {

    public function __construct() {
        parent::__construct();
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
        echo $this->view->display('model/index.php');
    }

}
