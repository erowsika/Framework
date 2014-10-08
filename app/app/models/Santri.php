<?php

/**
 * Description of User
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace app\models;

use system\db\Model;

class Users extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function rules() {
        return array(
            array(
                'label' => 'name',
                'field' => 'name',
                'rules' => 'type:string|min:0|required:true|trim:true'),
            array(
                'label' => 'email',
                'field' => 'name',
                'rules' => 'type:email|min:0|required:true|trim:true'),
        );
    }

}

$db = \Sby::instance()->db->createDb();
$result = $db->query('select * from users');
foreach ($hasil->fetchArray() as $value) {
    var_dump($value);
}
