<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Mibu
 *
 * @author masfu
 */
use \App;
use system\db\Model;

class Mibu extends Model {

    public function __construct() {
        parent::__construct('ibu');
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
                            'label' => 'username',
                            'field' => 'username',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'password',
                            'field' => 'password',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'salt',
                            'field' => 'salt',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'alamat',
                            'field' => 'alamat',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'rt',
                            'field' => 'rt',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'rw',
                            'field' => 'rw',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'kelurahan',
                            'field' => 'kelurahan',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'kecamatan',
                            'field' => 'kecamatan',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'tgl_lahir',
                            'field' => 'tgl_lahir',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true'),
                         array(
                            'label' => 'foto',
                            'field' => 'foto',
                            'rules' => 'type:string|min:0|max:50|required:true|trim:true')
        );
    }
}
