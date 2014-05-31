<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of {model_class}
 *
 * @author masfu
 */
use \App;
use system\db\Model;

class {model_class} extends Model {

    public function __construct() {
        parent::__construct('{table}');
    }

    public function rules() {
        return array(
            {rules}
        );
    }
}
