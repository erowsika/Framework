<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Captcha
 *
 * @author masfu
 */
use system\core\Base;

class Captcha {

    private $img;
    private $lenght;
    private $width;
    private $height;
    private $fontsize = 30;
    private $sessionVar = 'captcha';

    /**
     * public constructor
     * @param integer $lenght
     * @param integer $width
     * @param integer $height
     */
    public function __construct($lenght = 5, $width = 100, $height = 30) {
        $this->lenght = $lenght;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * validate capthca
     * @param string $str
     * @return boolean
     */
    public function validate($str) {
        if (isset($arr) && is_array($arr)) {
            if (isset($arr[$this->sessionvar])) {
                if ($arr[$this->sessionvar] == Base::instance()->session->getData($this->sessionVar)) {
                    return true;
                }
            }
        }
    }

    /**
     * generate random string
     * @param integer $lenght
     * @return string
     */
    private function generateRandomString($length = 6) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $string = "";
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    /**
     * create random image
     */
    public function create() {
        $this->img = ImageCreate($this->width, $this->height);
        if ($this->img) {
            header("Content-type: image/png");

            $bg = ImageColorAllocate($this->img, 255, 255, 255);
            $txt = ImageColorAllocate($this->img, 0, 0, 0);
            $noise_color = imagecolorallocate($this->img, 100, 120, 180);

            $string = $this->generateRandomString($this->lenght);


            for ($i = 0; $i < ($this->width * $this->height) / 3; $i++) {
                imagefilledellipse($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), 1, 1, $noise_color);
            }

            imagestring ($this->img, 100, $this->fontsize, 0, $string, $txt);
            Imagepng($this->img);

            Base::instance()->session->setData($this->sessionVar, $string);
        }
    }

}
