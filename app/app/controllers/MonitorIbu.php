<?php

namespace app\controllers;

/**
 * Description of MonitorIbu
 * @package name
 * @author your name
 * @copyright (c) 2014, your name
 */
use \App;
use app\core\Controller;
use app\models\monitor_ibu;

class MonitorIbu extends Controller {

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
        $monitor_ibu = new MmonitorIbu();
        $like = App::instance()->input->get('q');
        $offset = App::instance()->input->get('page');
        $limit = 10;

        $this->list_monitor_ibu = $monitor_ibu->find()->where($where)->limit($limit, $offset)->All();
        $this->paging = $monitor_ibu->paging($limit, $offset);

        $this->display("monitor_ibu/index.php");
    }

    /**
     * add data
     * @access public
     */
    public function add() {
        if (!empty(App::instance()->input->isPost())) {
            $monitor_ibu = new MmonitorIbu();
            $monitor_ibu->attributes = $_POST;
            if ($monitor_ibu->save()) {
                $this->redirect('MonitorIbu');
            }
        }
        $this->display("monitor_ibu/form.php");
    }

    /**
     * delete data
     * @access public
     */
    public function edit($id_monitor_ibu = null) {
            $monitor_ibu = new MmonitorIbu();
            if (!empty(App::instance()->input->isPost())) {
                $monitor_ibu->attributes = $_POST;
                $monitor_ibu->id_monitor_ibu = $id_monitor_ibu;
                if ($monitor_ibu->update()) {
                    $this->redirect('MonitorIbu');
                }
            }
            $data = MonitorIbu->findByPk($id)->All();
            if (!empty($data)) {
                $this->display("monitor_ibu/edit.php", reset($data));
            } else {
                throw new HttpException('Page not found', 404);
            }
    }
    
    /**
     * delete data
     * @access public
     */
    public function delete($id_monitor_ibu) {
        if (is_numeric($id)) {
            $monitor_ibu = new MmonitorIbu();
            $monitor_ibu->id_monitor_ibu = $id_monitor_ibu;
            if ($monitor_ibu->delete()) {
                $this->redirect('MonitorIbu');
            }
        }
    }

}
