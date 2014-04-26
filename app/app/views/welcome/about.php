<?php

$menu = array(
    array('title' => 'Beranda', 'url' => '/', 'visible' => true),
    array('title' => 'Data Master', 'url' => '', 'visible' => true, 'submenu' => 
        array(
            array('title' => 'Ibu', 'url' => '/ibu/data'),
            array('title' => 'Anak', 'url' => '/anak'))));

$menu = new \system\helper\Navbar($menu);
echo $menu->render();
?>