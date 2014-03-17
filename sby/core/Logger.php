<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logger
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace sby\core;

class Logger {

    public static function printError(
    Exception $exception, $clear = false, $error_file = 'exceptions_log.html'
    ) {
        $message = $exception->getMessage();
        $code = $exception->getCode();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $trace = $exception->getTraceAsString();
        $date = date('M d, Y h:iA');

        $log_message = "<h3>Exception information:</h3>
            <p>
                <strong>Date:</strong> {$date}
            </p>
             
            <p>
                <strong>Message:</strong> {$message}
            </p>
           
            <p>
                <strong>Code:</strong> {$code}
            </p>
             
            <p>
                <strong>File:</strong> {$file}
            </p>
             
            <p>
                <strong>Line:</strong> {$line}
            </p>
             
            <h3>Stack trace:</h3>
            <pre>{$trace}
            </pre>
            <br />
            <hr /><br /><br />";

        echo $log_message . $content;
        die;
    }

}
