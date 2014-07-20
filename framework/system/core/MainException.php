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
        ob_clean();
        header("HTTP/1.1 500 Internal Server Error", true, 500);

        $fileError = ERROR_PATH . '/error' . EXT_FILE;

        if (file_exists($fileError)) {
            include $fileError;
        } else {
            echo $message;
        }
        exit(1);
    }

    public static function handleError($code, $message, $file, $line) {
        if ($code & error_reporting()) {
            // disable error capturing to avoid recursive errors
            restore_error_handler();
            restore_exception_handler();

            $log = "$message ($file:$line)\nStack trace:\n";
            $trace = debug_backtrace();
            // skip the first 3 stacks as they do not tell the error position
            if (count($trace) > 3)
                $trace = array_slice($trace, 3);
            foreach ($trace as $i => $t) {
                if (!isset($t['file']))
                    $t['file'] = 'unknown';
                if (!isset($t['line']))
                    $t['line'] = 0;
                if (!isset($t['function']))
                    $t['function'] = 'unknown';
                $log.="#$i {$t['file']}({$t['line']}): ";
                if (isset($t['object']) && is_object($t['object']))
                    $log.=get_class($t['object']) . '->';
                $log.="{$t['function']}()\n";
            }
            if (isset($_SERVER['REQUEST_URI']))
                $log.='REQUEST_URI=' . $_SERVER['REQUEST_URI'];

            try {
                self::displayError($code, $message, $file, $line);
            } catch (Exception $e) {
                self::displayException($e);
            }

            try {
                exit();
            } catch (Exception $e) {
                // use the most primitive way to log error
                $msg = get_class($e) . ': ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
                $msg .= $e->getTraceAsString() . "\n";
                $msg .= "Previous error:\n";
                $msg .= $log . "\n";
                $msg .= '$_SERVER=' . var_export($_SERVER, true);
                error_log($msg);
                exit(1);
            }
        }
    }

    public static function displayError($code, $message, $file, $line) {
        echo "<h1>PHP Error [$code]</h1>\n";
        echo "<p>$message ($file:$line)</p>\n";
        echo '<pre>';

        $trace = debug_backtrace();
        // skip the first 3 stacks as they do not tell the error position
        if (count($trace) > 3)
            $trace = array_slice($trace, 3);
        foreach ($trace as $i => $t) {
            if (!isset($t['file']))
                $t['file'] = 'unknown';
            if (!isset($t['line']))
                $t['line'] = 0;
            if (!isset($t['function']))
                $t['function'] = 'unknown';
            echo "#$i {$t['file']}({$t['line']}): ";
            if (isset($t['object']) && is_object($t['object']))
                echo get_class($t['object']) . '->';
            echo "{$t['function']}()\n";
        }

        echo '</pre>';
    }

    public static  function displayException($exception) {
        echo '<h1>' . get_class($exception) . "</h1>\n";
        echo '<p>' . $exception->getMessage() . ' (' . $exception->getFile() . ':' . $exception->getLine() . ')</p>';
        echo '<pre>' . $exception->getTraceAsString() . '</pre>';
    }

    public static function handleException($exception) {
        // disable error capturing to avoid recursive errors
        restore_error_handler();
        restore_exception_handler();

        $category = 'exception.' . get_class($exception);

        // php <5.2 doesn't support string conversion auto-magically
        $message = $exception->__toString();
        if (isset($_SERVER['REQUEST_URI']))
            $message.="\nREQUEST_URI=" . $_SERVER['REQUEST_URI'];
        if (isset($_SERVER['HTTP_REFERER']))
            $message.="\nHTTP_REFERER=" . $_SERVER['HTTP_REFERER'];
        $message.="\n---";

        try {
            self::displayException($exception);
        } catch (Exception $e) {
            self::displayException($e);
        }

        try {
            exit();
        } catch (Exception $e) {
            // use the most primitive way to log error
            $msg = get_class($e) . ': ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            $msg .= $e->getTraceAsString() . "\n";
            $msg .= "Previous exception:\n";
            $msg .= get_class($exception) . ': ' . $exception->getMessage() . ' (' . $exception->getFile() . ':' . $exception->getLine() . ")\n";
            $msg .= $exception->getTraceAsString() . "\n";
            $msg .= '$_SERVER=' . var_export($_SERVER, true);
            error_log($msg);
            exit(1);
        }
    }

}
