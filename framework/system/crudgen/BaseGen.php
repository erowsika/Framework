<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\crudgen;

/**
 * Description of CrudGen
 *
 * @author masfu
 */
use system\core\Base;
use system\core\BaseView;

class BaseGen extends BaseView {

    private $model;
    private $controller_name;
    private $model_name;
    public $layout = 'main.php';

    public function __construct() {
        parent::__construct();
        $this->setViewDir(__DIR__ . '/layout/');
        $this->init();
    }

    public function init() {
        $assets_dest = DIR_APP . "/assets";
        $assets = __DIR__."/assets/";
        $this->xcopy($assets, $assets_dest);
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @param       string   $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     */
    function xcopy($source, $dest, $permissions = 0755) {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }
       // chmod($dest, $permissions);
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->xcopy("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }

    public function run() {
        $mode = Base::instance()->input->get('mode');
        $generator = null;
        switch ($mode) {
            case '':
                echo $this->display('base\index.php');
                exit();
            case 'auth';
                $generator = new AuthGen();
                break;
            case 'controller';
                $generator = new ControllerGen();
                break;
            case 'model';
                $generator = new ModelGen();
                break;
            case 'view';
                $generator = new ViewGen();
                break;
            default:
                break;
        }
        $generator->run();
    }

}
