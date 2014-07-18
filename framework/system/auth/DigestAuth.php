<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\auth;

/**
 * Description of DigestAuth
 *
 * @author masfu
 */
class DigestAuth {

    public function __construct() {
        $realm = 'The batcave';

        $nonce = uniqid();
        $digest = $this->getDigest();

        if (is_null($digest))
            $this->requireLogin($realm, $nonce);

        $digestParts = digestParse($digest);

        $validUser = 'admin';
        $validPass = '1234';

        $A1 = md5("{$validUser}:{$realm}:{$validPass}");
        $A2 = md5("{$_SERVER['REQUEST_METHOD']}:{$digestParts['uri']}");

        $validResponse = md5("{$A1}:{$digestParts['nonce']}:{$digestParts['nc']}:{$digestParts['cnonce']}:{$digestParts['qop']}:{$A2}");

        if ($digestParts['response'] != $validResponse)
            $this->requireLogin($realm, $nonce);

        echo 'Well done sir, you made it all the way through the login!';
    }

    public function getDigest() {
        if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $digest = $_SERVER['PHP_AUTH_DIGEST'];
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {

            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']), 'digest') === 0)
                $digest = substr($_SERVER['HTTP_AUTHORIZATION'], 7);
        }
        return $digest;
    }

    public function requireLogin($realm, $nonce) {
        header('WWW-Authenticate: Digest realm="' . $realm . '",qop="auth",nonce="' . $nonce . '",opaque="' . md5($realm) . '"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Text to send if user hits Cancel button';
        die();
    }

    public function digestParse($digest) {
        // protect against missing data
        $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
        $data = array();

        preg_match_all('@(\w+)=(?:(?:")([^"]+)"|([^\s,$]+))@', $digest, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[2] ? $m[2] : $m[3];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }

}
