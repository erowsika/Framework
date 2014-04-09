<?php

/**
 * Description of HttpErrorException is to cacth error from invalid http request such as controller not found
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace core;

class HttpException extends \Exception {
    /* return error name
     * @return string
     */

    public function __construct($type, $message) {
        self::printError($type, $message);
    }

    public static function printError($type, $message) {

        $fileError = SYS_PATH.'/errors/' . $type.EXT_FILE;
        if (file_exists($fileError)) {
            include $fileError;
        } else
            echo 'file '.$fileError.' not found';
    }

}
