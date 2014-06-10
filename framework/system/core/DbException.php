<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\core;

/**
 * Description of DbException
 *
 * @author masfu
 */
class DbException extends \Exception {

    /**
     * constructor
     * @access public
     * @param string $message error message
     * @param string $code integer code error
     * @param Exception $previous exception
     * */
    public function __construct($message = '', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    
    /**
     * print error message
     */
    public function printError() {
        $message = $this->message;
        $line = $this->line;
        $code = $this->code;
        ob_clean();
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        $fileError = ERROR_PATH . '/db_error' . EXT_FILE;
        if (file_exists($fileError)) {
            include $fileError;
        } else {
            echo $message;
        }
        exit(1);
    }

}
