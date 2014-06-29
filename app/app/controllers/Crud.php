<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of Crud
 *
 * @author masfu
 */
use app\core as app;
use system\crudgen\BaseGen;
use app\moduls\Chat;
use Ratchet\Server\IoServer;

class Crud extends app\Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $server = IoServer::factory(
                        new Chat(), 443
        );

        $server->run();
    }

}
