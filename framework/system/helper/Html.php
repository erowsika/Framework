<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Html
 *
 * @author masfu
 */
use system\core\Base;

class Html {

    public static function formOpen($action = null, $method = 'post', $param = '') {

        if ($action and strpos($action, '://') === false) {
            $action = Base::instance()->base_url . $action;
        }
        $form = "<form action='$action' method='$method' $param>";
        return $form;
    }

    public static function formOpenMultiPart($action = null, $method = 'post', $param = '') {
        $param .= " enctype='multipart/form-data'";
        return $this->formOpen($action, $method, $param);
    }

    public static function formHidden($name, $value = '', $extra = '') {
        return "<input type=\"hidden\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function textField($name, $value = '', $extra = '') {
        return "<input type=\"text\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function passwordField($name, $value = '', $extra = '') {
        return "<input type=\"password\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function fileField($name, $value = '', $extra = '') {
        return "<input type=\"file\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function textArea($name, $col, $row, $value = '', $extra = '') {
        return "<textarea name=\"$name\" cols=$col rows=$row $extra>$value</textarea>";
    }

    public static function dropDownList($name = '', $options = array(), $selected = array(), $extra = '', $multiple = '') {
        if (!is_array($selected)) {
            $selected = array($selected);
        }
        if (count($selected) === 0) {
            if (isset($_POST[$name])) {
                $selected = array($_POST[$name]);
            }
        }
        $form = '<select name="' . $name . '"' . $extra . $multiple . ">\n";

        foreach ($options as $key => $val) {

            $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';
            $form .= '<option value="' . $key . '"' . $sel . '>' . $val . "</option>\n";
        }

        $form .= '</select>';
        return $form;
    }

    public static function dropDown($name = '', $options = array(), $selected = array(), $extra = '') {
        
    }

    public static function checkBox($name, $value = '', $extra = '') {
        return "<input type=\"checkbox\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function radioButton($name, $value = '', $extra = '') {
        $extra = ($value == $extra) ? 'checked' : '';
        return "<input type=\"radio\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function submitButton($name, $value = '', $extra = '') {
        return "<input type=\"submit\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function resetButton($name, $value = '', $extra = '') {
        return "<input type=\"reset\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function button($name, $value = '', $extra = '') {
        return "<input type=\"button\" name=\"$name\" value=\"$value\" $extra>";
    }

    public static function label($label, $for, $param) {
        return "<label for=\"$for\" $param >$label</label>";
    }

    public static function fieldSet($title, $param) {
        return "<fieldset $param><legend>$title</legend>";
    }

    public static function fieldSetClose() {
        return "</fieldset>";
    }

    public static function formClose($extra = '') {
        return "</form>";
    }

    public static function prep($str = '', $field_name = '') {
        
    }

    public static function setValue($field = '', $default = '') {
        
    }

    public static function setSelect($field = '', $value = '', $default = FALSE) {
        
    }

    public static function setCheckBox($field = '', $value = '', $default = FALSE) {
        
    }

    public static function setRadio($field = '', $value = '', $default = FALSE) {
        
    }

    public static function formError($field = '', $prefix = '', $suffix = '') {
        $error = Base::instance()->session->flashData('error');
        if (isset($error[$field])) {
            $error = $error[$field];
        } else {
            $error = '';
        }
        return '<small style="color:red;">' . $error . '</small>';
    }

    public static function validationErrors($prefix = '', $suffix = '') {
        $error = Base::instance()->session->flashData('error');
    }

    public static function link($uri = '', $title = '', $attributes = '') {
        return "<a href=\"$uri\" $attributes>$title</a>";
    }

    public static function linkPopUp($uri = '', $title = '', $attributes = FALSE) {
        
    }

    public static function linkEmail($email, $title = '', $attributes = '') {
        
    }

    public static function linkEmailSafe($email, $title = '', $attributes = '') {
        
    }

    public static function linkAuto($str, $type = 'both', $popup = FALSE) {
        
    }

    public static function heading($title = '', $h = '1', $param = '') {
        return "<h$h $param>$title</h$h>";
    }

    public static function ul($list, $attributes = '') {
        if (!is_array($list)) {
            return $list;
        }
        $out = str_repeat(" ", $depth);
        if (is_array($attributes)) {
            $atts = '';
            foreach ($attributes as $key => $val) {
                $atts .= ' ' . $key . '="' . $val . '"';
            }
            $attributes = $atts;
        } elseif (is_string($attributes) AND strlen($attributes) > 0) {
            $attributes = ' ' . $attributes;
        }
        $out .= "<" . $type . $attributes . ">\n";
        static $_last_list_item = '';
        foreach ($list as $key => $val) {
            $_last_list_item = $key;

            $out .= str_repeat(" ", $depth + 2);
            $out .= "<li>";

            if (!is_array($val)) {
                $out .= $val;
            } else {
                $out .= $_last_list_item . "\n";
                $out .= _list($type, $val, '', $depth + 4);
                $out .= str_repeat(" ", $depth + 2);
            }

            $out .= "</li>\n";
        }

        // Set the indentation for the closing tag
        $out .= str_repeat(" ", $depth);

        // Write the closing list tag
        $out .= "</" . $type . ">\n";

        return $out;
    }

    public static function ol($list, $attributes = '') {
        
    }

    public static function listData($type = 'ul', $list, $attributes = '', $depth = 0) {
        
    }

    public static function image($src = '', $param = '') {
        return "<img src=\"$src\" $param/>";
    }

}
