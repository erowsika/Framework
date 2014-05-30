<?php

namespace app\controllers;

/**
 * Description of Bidan
 * @package name
 * @author your name
 * @copyright (c) 2014, your name
 */
use \App;
use app\core\Controller;
use app\models\mbidan;

class Bidan extends Controller {

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
        $mbidan = new Mbidan();
        $like = App::instance()->input->get('q');
        $offset = App::instance()->input->get('page');
        $limit = 10;

        $this->list_mbidan = $mbidan->find()->where($where)->limit($limit, $offset)->All();
        $this->paging = $mbidan->paging($limit, $offset);

        $this->display("bidan/index.php");
    }

    /**
     * add data
     * @access public
     */
    public function add() {
        if (!empty(App::instance()->input->isPost())) {
            $mbidan = new Mbidan();
            $mbidan->attributes = $_POST;
            if ($mbidan->save()) {
                $this->redirect('Bidan');
            }
        }
        $this->display("bidan/form.php");
    }

    /**
     * delete data
     * @access public
     */
    public function edit($id = null) {
            $mbidan = new Mbidan();
            if (!empty(App::instance()->input->isPost())) {
                $mbidan->attributes = $_POST;
                $mbidan->id = $id;
                if ($mbidan->update()) {
                    $this->redirect('Bidan');
                }
            }
            $data = Bidan->findByPk($id)->All();
            if (!empty($data)) {
                $this->display("bidan/edit.php", reset($data));
            } else {
                throw new HttpException('Page not found', 404);
            }
    }
    
    /**
     * delete data
     * @access public
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $mbidan = new Mbidan();
            $mbidan->id = $id;
            if ($mbidan->delete()) {
                $this->redirect('Bidan');
            }
        }
    }

}
