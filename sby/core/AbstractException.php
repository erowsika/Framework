<?php

/*
 *
 */

/**
 * Description of AbstractException
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
namespace sby\core;

abstract class AbstractException extends Exception{
    
    abstract function getErrorMessage();
    abstract function stackTrace();
    abstract function printMessage();
}
