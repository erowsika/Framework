<?php

namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core as app;
use app\models\Santri;

class TestModel extends app\Controller {

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
        $mysql = new Santri();
        $tb = $mysql->first();
        print_r($tb);
    }

    public function last() {
        $mysql = new Santri();
        $tb = $mysql->last();
        print_r($tb);
    }

    public function insert() {
        $mysql = new MongoDb();
        $tb = $mysql->insert();
    }

    public function countAll() {
        $mysql = new Santri();
        echo $mysql->countAll();
    }

    public function update() {
        $mysql = new Santri();
        $mysql->santri_id = '79';
        $mysql->nama_santri = 'arintiya dan masfu';
        $mysql->alamat_santri = 'benowo';
        $mysql->tgl_lahir_santri = '1995-07-06';
        $mysql->tmp_lahir_santri = 'jombang';
        $this->tahun_masuk = '2010';
        $mysql->update();
        $tb = $mysql->findByPk(79);
        print_r($tb);
    }

    public function delete() {
        $mysql = new Santri();
        $mysql->santri_id = '79';
        $tb = $mysql->delete();
    }

    public function select() {
        $mysql = new Santri();
        $tb = $mysql->findBySql("SELECT * FROM santri");
        print_r($tb);
    }

    public function findAll() {
        $mysql = new Santri();
        $tb = $mysql->find();
        print_r($tb);
    }

    public function save() {
        $mysql = new Santri();
        $mysql->nama_santri = 'arintiya';
        $mysql->alamat_santri = 'benowo';
        $mysql->tgl_lahir_santri = '1995-07-06';
        $mysql->tmp_lahir_santri = 'jombang';
        $this->tahun_masuk = '2010';
        $mysql->save();
        $tb = $mysql->last();
        print_r($tb);
    }

    public function findByPk() {
        $mysql = new Santri();
        $tb = $mysql->findByPk(5);
        print_r($tb);
    }

    /**
     * method before execution
     */
    public function beforeExecute() {
        
    }

    /**
     * method after execution
     */
    public function afterExcetion() {
        
    }

}
