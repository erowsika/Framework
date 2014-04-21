<?php

//if( isset($_GET['php-benchmark-test']) ) {
require __DIR__ . '/lib/PHPBenchmark/Monitor.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
} else {
    \PHPBenchmark\Monitor::instance()->init(1);
}
//}

