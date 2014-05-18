<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Validator
 * inspired by http://www.phpro.org/classes/Validation-Class.html
 * @author masfu
 */
class Validator {

    private $attributes = array();
    private $errors = array();
    private $rules = array();
    private $sanitized = array();
    private $error_message = array(
        1 => ' is not a valid IPv4',
        2 => ' is not a valid IPv6',
        3 => ' is an invalid float',
        4 => ' is too short',
        5 => ' is too long',
        6 => ' is invalid',
        7 => ' is an invalid number',
        8 => ' is not a valid URL',
        9 => ' is not a valid email address',
        10 => ' is not set',
        11 => ' this value must be unique'
    );

    /**
     * 
     * @param type $attributes
     * @param type $model
     */
    public function __construct($attributes = array(), $model = null) {
        $this->attributes = $attributes;
        $this->model = $model;
    }

    /**
     * 
     * @param type $attributes
     */
    public function setAttributes($attributes) {
        $this->attributes = $attributes;
    }

    /**
     * 
     * @return type
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * 
     * @param type $name
     * @param type $rules
     */
    public function addRules($name, $rules = '') {
        if (is_array($name) and $rules == '') {
            $this->rules = array_merge($this->rules, $name);
        } else {
            $this->rules[$name] = $rules;
        }
    }

    public function validate() {
        foreach ($this->rules as $key => $value) {
            $opt = $this->parseRules($value);

            if (array_key_exists('trim', $opt) and $opt['required'] == true) {
                $this->is_set($key);
            }

            if (array_key_exists('trim', $opt) and $opt['trim'] == true and array_key_exists($key, $this->attributes)) {
                $this->attributes[$key] = trim($this->attributes[$key]);
            }

            if (array_key_exists('unique', $opt)) {
                $this->validateUnique($this->attributes[$key], $key);
            }

            if (!isset($opt['min'])) {
                $opt['min'] = 0;
            }

            if (!isset($opt['max'])) {
                $opt['max'] = 255;
            }

            switch ($opt['type']) {
                case 'email':
                    $this->validateEmail($key, $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeEmail($key);
                    }
                    break;

                case 'url':
                    $this->validateUrl($key);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeUrl($key);
                    }
                    break;

                case 'numeric':
                    $this->validateNumeric($key, $opt['min'], $opt['max'], $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeNumeric($key);
                    }
                    break;

                case 'string':
                    $this->validateString($key, $opt['min'], $opt['max'], $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeString($key);
                    }
                    break;

                case 'float':
                    $this->validateFloat($key, $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeFloat($key);
                    }
                    break;

                case 'ipv4':
                    $this->validateIpv4($key, $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeIpv4($key);
                    }
                    break;

                case 'ipv6':
                    $this->validateIpv6($key, $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitizeIpv6($key);
                    }
                    break;

                case 'bool':
                    $this->validateBool($key, $opt['required']);
                    if (!array_key_exists($key, $this->errors)) {
                        $this->sanitized[$key] = (bool) $this->attributes[$key];
                    }
                    break;
            }
        }

        return (count($this->errors) > 0 ? false : true);
    }

    private function parseRules($rules) {
        $rules = explode('|', $rules);
        $result = array();
        foreach ($rules as $key => $value) {
            $elem = explode(':', $value);
            $type = reset($elem);
            $value = end($elem);
            $result[$type] = $value;
        }
        return $result;
    }

    /**
     * 
     * @param type $var
     * @param type $column
     * @return boolean
     */
    private function validateUnique($var, $column) {
        if (!empty($this->model->find(array('where' => "$column = '$var'")))) {
            $this->errors[$var] = $var . $this->error_message[8];
        } else {
            return true;
        }
    }

    /**
     * 
     * @param type $var
     */
    private function is_set($var) {
        if (!isset($this->attributes[$var])) {
            $this->errors[$var] = $var . $this->error_message[10];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $required
     * @return boolean
     */
    private function validateIpv4($var, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }
        if (filter_var($this->attributes[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE) {
            $this->errors[$var] = $var . $this->error_message[1];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $required
     * @return boolean
     */
    public function validateIpv6($var, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }

        if (filter_var($this->attributes[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === FALSE) {
            $this->errors[$var] = $var . $this->error_message[2];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $required
     * @return boolean
     */
    private function validateFloat($var, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }
        if (filter_var($this->attributes[$var], FILTER_VALIDATE_FLOAT) === false) {
            $this->errors[$var] = $var . $this->error_message[3];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $min
     * @param type $max
     * @param type $required
     * @return boolean
     */
    private function validateString($var, $min = 0, $max = 0, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }

        if (isset($this->attributes[$var])) {
            if (strlen($this->attributes[$var]) < $min) {
                $this->errors[$var] = $var . $this->error_message[4];
            } elseif (strlen($this->attributes[$var]) > $max) {
                $this->errors[$var] = $var . $this->error_message[5];
            } elseif (!is_string($this->attributes[$var])) {
                $this->errors[$var] = $var . $this->error_message[6];
            }
        }
    }

    /**
     * 
     * @param type $var
     * @param type $min
     * @param type $max
     * @param type $required
     * @return boolean
     */
    private function validateNumeric($var, $min = 0, $max = 0, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }
        if (filter_var($this->attributes[$var], FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max))) === FALSE) {
            $this->errors[$var] = $var . $this->error_message[7];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $required
     * @return boolean
     */
    private function validateUrl($var, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }
        if (filter_var($this->attributes[$var], FILTER_VALIDATE_URL) === FALSE) {
            $this->errors[$var] = $var . $this->error_message[8];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $required
     * @return boolean
     */
    private function validateEmail($var, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }
        if (filter_var($this->attributes[$var], FILTER_VALIDATE_EMAIL) === FALSE) {
            $this->errors[$var] = $var . $this->error_message[9];
        }
    }

    /**
     * 
     * @param type $var
     * @param type $required
     * @return boolean
     */
    private function validateBool($var, $required = false) {
        if ($required == false && strlen($this->attributes[$var]) == 0) {
            return true;
        }
        filter_var($this->attributes[$var], FILTER_VALIDATE_BOOLEAN); {
            $this->errors[$var] = $var . $this->error_message[6];
        }
    }

    /**
     * 
     * @param type $var
     */
    public function sanitizeEmail($var) {
        $email = preg_replace('((?:\n|\r|\t|%0A|%0D|%08|%09)+)i', '', $this->attributes[$var]);
        $this->sanitized[$var] = (string) filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * 
     * @param type $var
     */
    private function sanitizeUrl($var) {
        $this->sanitized[$var] = (string) filter_var($this->attributes[$var], FILTER_SANITIZE_URL);
    }

    /**
     * 
     * @param type $var
     */
    private function sanitizeNumeric($var) {
        $this->sanitized[$var] = (int) filter_var($this->attributes[$var], FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * 
     * @param type $var
     */
    private function sanitizeString($var) {
        $this->sanitized[$var] = (string) filter_var($this->attributes[$var], FILTER_SANITIZE_STRING);
    }

}
