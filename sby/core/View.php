<?php

/**
 * Description of View
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace core;

class View {

    /* send output to browser
     * @param $
     * 
     */
    public function output($view, $data = array(), $returnString = false) {

        if (!file_exists($path)) {
            echo "File " . $path . "  Tidak ditemukan";
            die;
        }


        $data = $this->object_to_array($data);

        $cached_vars = array();

        if (is_array($data)) {
            $cached_vars = array_merge($cached_vars, $data);
        }
        extract($cached_vars);


        if ($returnString) {
            ob_start();
            include $path;
            $output = ob_get_contents();
            @ob_end_clean();
            return $output;
        }
        include $path;
    }

    /* convert object to associative array
     * 
     * @param object
     * @return array
     */
    protected function object_to_array($object) {
        return (is_object($object)) ? get_object_vars($object) : $object;
    }
}
