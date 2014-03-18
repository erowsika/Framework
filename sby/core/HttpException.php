<?php

/**
 * Description of HttpErrorException is to cacth error from invalid http request such as controller not found
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace sby\core;

class HttpException extends \Exception {

    /* return error name
     * @return string
     */
    public function getErrorMessage() {
        return 'Invalid http';
    }
    /*
     * print error to browser
     */
    public function printMessage() {
        
    }

    /*
     * print stack trace error
     */
    public function stackTrace() {
        
    }

}
