<?php

/**
 * Description of MainException
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace core;

class MainException extends \Exception {
    /*
     * public constructor
     * @param string
     * @param int
     * @param Exception
     */

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function show() {
        $message = $this->getMessage();
        $file = false;
        $line = false;
        $traceAsString = $this->getTraceAsString();

        foreach ($this->getTrace() as $trace) {
            if (isset($trace['file'])) {
                $file = $trace['file'];
                if (isset($trace['line'])) {
                    $line = $trace['line'];
                }
                break;
            }
        }
        
        $this->printError($message, $file, $line, $traceAsString);
    }

    /* @acces static
     * @param string
     * @return void
     * 
     */

    public function printError($message = null, $file = false, $line = false, $trace = false) {
        // Message for log
        $errorMessage = 'Error ' . $message . ' in ' . $file . ' line: ' . $line;

        // Write the error to log file
        @error_log($errorMessage);

        // Just output the error if the error source for view file or if in cli mode.
        if ((array_search('views', explode('/', $file)) !== false) || (PHP_SAPI == 'cli')) {
            exit($errorMessage);
        }

        $code = array();

        if ($file) {
            $fileString = file_get_contents($file);
            $arrLine = explode("\n", $fileString);
            $totalLine = count($arrLine);
            $getLine = array_combine(range(1, $totalLine), array_values($arrLine));
            $startIterate = $line - 5;
            $endIterate = $line + 5;

            if ($startIterate < 0)
                $startIterate = 0;

            if ($endIterate > $totalLine)
                $endIterate = $totalLine;

            for ($i = $startIterate; $i <= $endIterate; $i++) {

                $html = '<span style="margin-right:10px;background:#CFCFCF;">' . $i . '</span>';

                if ($line == $i)
                    $html .= '<span style="color:#DD0000">' . $getLine[$i] . "</span>\n";
                else
                    $html .= $getLine[$i] . "\n";

                $code[] = $html;
            }
        }

        $data = array(
            'message' => $message,
            'file' => $file,
            'line' => $line,
            'code' => $code,
            'trace' => $trace
        );

        header("HTTP/1.1 500 Internal Server Error", true, 500);

        exit(1);
    }

}
