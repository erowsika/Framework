<?php

/**
 * Description of MainException
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace system\core;

class MainException extends \Exception {

    /**
     *
     * @var string 
     */
    private $log_file = 'error.log';

    /**
     * public constructor
     * @param string
     * @param int
     * @param Exception
     * */
    public function __construct($message = null, $code = 0) {

        parent::__construct($message, $code);
        $this->toString();
        $this->log();
    }

    /**
     * 
     * log to file
     * @access private
     * @return void
     */
    private function log() {
        if ($fp = fopen(LOGS_PATH . $this->log_file, 'a')) {
            $log_msg = date("[Y-m-d H:i:s]") .
                    " Code: $code - " .
                    " Message: $message\n";

            fwrite($fp, $log_msg);
            fclose($fp);
        }
    }

    /* @acces public
     * @param string
     * @return void
     * 
     */

    public function toString() {

        $message = $this->getMessage();
        $file = false;
        $line = false;
        $code = "";
        foreach ($this->getTrace() as $trace) {
            if (isset($trace['file'])) {
                $file = $trace['file'];

                if (isset($trace['line'])) {
                    $line = $trace['line'];
                }

                break;
            }
        }



        if ($file) {
            $fileString = file_get_contents($file);
            $lines = explode("\n", $fileString);
            $getLine = array_combine(range(1, count($lines)), array_values($lines));

            foreach ($getLine as $key => $value) {
                $value = htmlentities($value);
                $html = '<span style="margin-right:10px;background:#CFCFCF;">' . $key . '</span>';

                if ($line == $key) {
                    $html .= '<span style="color:#DD0000">' . $value . "</span>\n";
                } else {
                    $html .= $value . "\n";
                }
                $code .= $html . "<br>";
            }
        }
        header("HTTP/1.1 500 Internal Server Error", true, 500);

        $fileError = SYS_PATH . '/errors/error' . EXT_FILE;

        if (file_exists($fileError)) {
            include $fileError;
        } else {
            echo $message;
        }
        exit(1);
    }

}
