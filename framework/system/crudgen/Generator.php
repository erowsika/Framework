<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\crudgen;

/**
 * Description of Generator
 *
 * @author masfu
 */
use system\core\Base;

class Generator {

    protected $table;
    protected $primary_key;
    protected $controller;
    protected $model;
    protected $model_class;
    protected $view_dir;
    protected $attributes = array();
    protected $view;

    /**
     * 
     */
    public function __construct() {
        $this->table = Base::instance()->input->get('table');
        $this->initTable();

        $this->controller = Base::instance()->input->get('controller');
        $this->model = $this->table;
        $this->model_class = Base::instance()->input->get('model');
        $this->view_dir = $this->table;

        $this->view = new \system\core\BaseView();
        $this->view->setViewDir(__DIR__ . '/layout/');
        $this->view->layout = 'main.php';
    }

    /**
     * 
     */
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

    /**
     * 
     * @param type $location
     * @param type $code
     * @return type
     */
    public function write($location, $code) {
        file_put_contents($location, $code);
        return trim(htmlentities($code));
    }

    /**
     * 
     * @param type $location
     * @param type $code
     */
    public function download($location, $code) {
        file_put_contents($location, $code);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($location) . '"');
        header('Content-Length: ' . filesize($location));
        readfile($location);
        if (file_exists($location)) {
            unlink($location);
        }
    }

}
