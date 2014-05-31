<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Mbalita
 *
 * @author masfu
 */
use \App;
use system\db\Model;

class Mbalita extends Model {

    public function __construct() {
        parent::__construct('balita');
    }

    public function rules() {
        return array(
            
                         array(
                            'label' => 'id',
                            'field' => 'id',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'nama',
                            'field' => 'nama',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'alamat',
                            'field' => 'alamat',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'ibu',
                            'field' => 'ibu',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'tgl_lahir',
                            'field' => 'tgl_lahir',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'berat_lahir',
                            'field' => 'berat_lahir',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'tinggi_lahir',
                            'field' => 'tinggi_lahir',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'cacat_lahir',
                            'field' => 'cacat_lahir',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'gol_darah',
                            'field' => 'gol_darah',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'ibu_id',
                            'field' => 'ibu_id',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'anak_ke',
                            'field' => 'anak_ke',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'jenis_kelamin',
                            'field' => 'jenis_kelamin',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true')
        );
    }
}
