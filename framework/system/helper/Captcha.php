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

    const CAPTCHA_ERROR = "code you have entered mismacth";

    private $img;
    private $lenght;
    private $width;
    private $height;
    private $fontsize = 30;
    private $font = "";
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
        $this->font = __DIR__ . '/fonts/monofont.ttf';
        $this->fontsize = $this->height * 0.75;
    }

    /**
     * validate capthca
     * @param string $str
     * @return boolean
     */
    public function validate($str) {
        if ($str == Base::instance()->session->getData($this->sessionVar)) {
            Base::instance()->session->unsetSess($this->sessionVar);
            return true;
        }
        return false;
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
            $noise_color = imagecolorallocate($this->img, 100, 120, 180);
            $text_color = imagecolorallocate($this->img, 20, 40, 100);

            $string = $this->generateRandomString($this->lenght);


            for ($i = 0; $i < ($this->width * $this->height) / 3; $i++) {
                imagefilledellipse($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), 1, 1, $noise_color);
            }

            $textbox = imagettfbbox($this->fontsize, 0, $this->font, $string);
            $x = ($this->width - $textbox[4]) / 2;
            $y = ($this->height - $textbox[5]) / 2;
            imagettftext($this->img, $this->fontsize, 0, $x, $y, $text_color, $this->font, $string);
            Imagepng($this->img);

            Base::instance()->session->setData($this->sessionVar, $string);
        }
    }

}
