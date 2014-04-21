<?php

/**
 * Description of HttpErrorException is to cacth error from invalid http request such as controller not found
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class HttpException extends \Exception {

    private $codes = array(
        400 => array('400 Bad Request', 'The request cannot be fulfilled due to bad syntax.'),
        401 => array('401 Login Error', 'It appears that the password and/or user-name you entered was incorrect.'),
        403 => array('403 Forbidden', 'Sorry, employees and staff only.'),
        404 => array('404 Missing', 'We\'re sorry, but the page you\'re looking for is missing, hiding, or maybe it moved somewhere else and forgot to tell you.'),
        405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
        408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
        414 => array('414 URL To Long', 'The URL you entered is longer than the maximum length.'),
        500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
        502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
        504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
    );

    /* return error name
     * @return string
     */

    public function __construct($message = '', $code = 0) {
        parent::__construct($message, $code);
    }

    public function printError() {
        $message = $this->message;
        $code = $this->code;
        $title = $message;
        $message = ($message == '') ? $this->codes[$code][0] : $message;

        if ($message == '') {
            $title = "Unknown Error";
            $message = "An unknown error has occurred.";
        }
        ob_clean();
        $fileError = ERROR_PATH . $code . EXT_FILE;
        header("HTTP/1.1 {$this->codes[$code][1]}", true, $code);
        if (file_exists($fileError)) {
            include $fileError;
        } else {
            echo $message;
        }
    }

}
