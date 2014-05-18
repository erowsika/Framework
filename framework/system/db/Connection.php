<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\db;

/**
 *
 * @author masfu
 */
interface Connection {

    public function initialize();

    public function connect();

    public function pconnect();

    public function dbSelect();

    public function disconnect();
}
