<?php

require_once(BASE_APP . '/vendors/smarty/libs/Smarty.class.php');

namespace app\moduls\smarty;

class SmartyView extends Smarty {

    function __construct() {
        parent::__construct();
        $this->setTemplateDir(BASE_APP . 'views/templates');
        $this->setCompileDir(BASE_APP . 'views/compiled');
        $this->setConfigDir(BASE_APP . 'libraries/smarty/configs');
        $this->setCacheDir(BASE_APP . 'libraries/smarty/cache');

        $this->assign('APPPATH', BASE_APP);
        $this->assign('BASEPATH', BASE_APP);
        if (method_exists($this, 'assignByRef')) {
            $ci = & get_instance();
            $this->assignByRef("ci", $ci);
        }
        $this->force_compile = 1;
        $this->caching = true;
        $this->cache_lifetime = 120;
    }

    function view($template_name) {
        if (strpos($template_name, '.') === FALSE &&
                strpos($template_name, ':') === FALSE) {
            $template_name .= '.tpl';
        }
        parent::display($template_name);
    }

}
