<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Menu
 *
 * @author masfu
 */
use system\core\Base;

class Navbar {

    private $menu;
    private $url;
    public $styleUl = 'class="nav navbar-nav"';
    public $styleLl = '';
    public $styleUlSubMenu = 'class="dropdown-menu"';
    public $styleLlSubMenu = 'class="dropdown"';
    public $styleLink = '';
    public $styleLinkSubmenu = 'class="dropdown-toggle" data-toggle="dropdown"';
    public $styleActive = 'class="active"';

    public function __construct($menu) {
        $this->menu = $menu;
        $this->url = Base::instance()->router->getUri();
    }

    public function setStyle() {
        
    }

    public function buildMenu($items, $level = 0) {
        $ret = "";
        $indent = str_repeat(" ", $level * 2);
        $ul = ($level > 0) ? $this->styleUlSubMenu : $this->styleUl;
        $ret .= "$indent<ul {$ul}>\n";
        $indent = str_repeat(" ", ++$level * 2);
        foreach ($items as $item => $subitems) {
            $title = $subitems['title'];
            $url = $subitems['url'];
            $visible = (isset($subitems['visible'])) ? $subitems['visible'] : TRUE;
            $submenu = (isset($subitems['submenu'])) ? $subitems['submenu'] : '';
            if (!$visible)
                continue;
            $li = (isset($subitems['submenu'])) ? $this->styleLlSubMenu : $this->styleLl;
            $link = (isset($subitems['submenu'])) ? $this->styleLinkSubmenu : $this->styleLink;
            $ret .= "$indent<li $li><a href='$url' $link>$title</a>";

            if (is_array($submenu)) {
                $ret .= "\n";
                $ret .= $this->buildMenu($submenu, $level + 1);
                $ret .= $indent;
            }
            $ret .= sprintf("</li>\n", $indent);
        }
        $indent = str_repeat(" ", --$level * 2);
        $ret .= sprintf("%s</ul>\n", $indent);
        return($ret);
    }

    public function render() {
        return $this->buildMenu($this->menu);
    }

}
