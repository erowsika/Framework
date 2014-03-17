<?php

/**
 * Description of Sby
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace sby\core;

class Sby {
    /*
     * this variable store the instance of the sby class
     * @var Sby
     * @access private
     */

    private $_instance;

    /* varible registry
     * @var Registry
     */
    private $registry;

    /* this is a constructor
     * @access public
     * 
     */
    private $listObject = array("");

    public function __construct() {
        $this->init();
    }

    /*
     * initialization
     * 
     */

    public function init() {
        $this->registry = Registry::getInstance();
        $this->initConfig();
    }

    private function initConfig() {
        $config = include(CONFIG_PATH . 'application.php');

        foreach ($config as $key => $conf) {
              $this->$key = $conf;
            if (is_array($conf)) {
                print_r($conf);
                echo "sfsf";
            } else
                echo "<br>".$conf;
        }
    }

}

?>
