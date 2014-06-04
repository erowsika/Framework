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
use app\models\Mbidan;

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
        $bidan = new Mbidan();
        $like = App::instance()->input->get('q');
        $offset = App::instance()->input->get('page');
        $limit = 10;

        $this->list_bidan = $bidan->find()->where($where)->limit($limit, $offset)->All();
        $this->paging = $bidan->paging($limit, $offset);

        $this->display("bidan/index.php");
    }

    /**
     * add data
     * @access public
     */
    public function add() {
        if (!empty(App::instance()->input->isPost())) {
            $bidan = new Mbidan();
            $bidan->attributes = $_POST;
            if ($bidan->save()) {
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
            $bidan = new Mbidan();
            if (!empty(App::instance()->input->isPost())) {
                $bidan->attributes = $_POST;
                $bidan->id = $id;
                if ($bidan->update()) {
                    $this->redirect('Bidan');
                }
            }
            $data = $bidan->findByPk($id)->All();
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
            $bidan = new Mbidan();
            $bidan->id = $id;
            if ($bidan->delete()) {
                $this->redirect('Bidan');
            }
        }
    }

}
