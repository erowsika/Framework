<?php

namespace app\controllers;

/**
 * Description of {controller}
 * @package name
 * @author your name
 * @copyright (c) 2014, your name
 */
use \App;
use app\core\Controller;
use app\models\{model};

class {controller} extends Controller {

    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * index page
     * @access public
     */
    public function index() {
        ${model} = new {model_class}();
        $like = App::instance()->input->get('q');
        $offset = App::instance()->input->get('page');
        $limit = 10;

        $this->list_{model} = ${model}->find()->where($where)->limit($limit, $offset)->All();
        $this->paging = ${model}->paging($limit, $offset);

        $this->display("{view_dir}/index.php");
    }

    /**
     * add data
     * @access public
     */
    public function add() {
        if (!empty(App::instance()->input->isPost())) {
            ${model} = new {model_class}();
            ${model}->attributes = $_POST;
            if (${model}->save()) {
                $this->redirect('{controller}');
            }
        }
        $this->display("{view_dir}/form.php");
    }

    /**
     * delete data
     * @access public
     */
    public function edit(${primary_key} = null) {
            ${model} = new {model_class}();
            if (!empty(App::instance()->input->isPost())) {
                ${model}->attributes = $_POST;
                ${model}->{primary_key} = ${primary_key};
                if (${model}->update()) {
                    $this->redirect('{controller}');
                }
            }
            $data = {controller}->findByPk($id)->All();
            if (!empty($data)) {
                $this->display("{view_dir}/edit.php", reset($data));
            } else {
                throw new HttpException('Page not found', 404);
            }
    }
    
    /**
     * delete data
     * @access public
     */
    public function delete(${primary_key}) {
        if (is_numeric($id)) {
            ${model} = new {model_class}();
            ${model}->{primary_key} = ${primary_key};
            if (${model}->delete()) {
                $this->redirect('{controller}');
            }
        }
    }

}
