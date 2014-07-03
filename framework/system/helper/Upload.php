<?php

namespace system\helper;

use \system\core\Base;

class Upload {

    private $uploadFile;
    private $uploadDir;
    private $name;
    private $tmp_name;
    private $type;
    private $field;
    private $errorMessage = array(
        '0' => 'Invalid upload directory.',
        '1' => 'Invalid number of file upload parameters.',
        '2' => 'Invalid MIME type of target file.');
    private $allowedTypes = array
        ('jpg', 'gif', 'png', 'bmp');

    public function __construct($name, $uploadDir, $destName = '', $mime = '') {

        if ($mime != '') {
            $this->allowedTypes = explode('|', $mime);
        }

        foreach ($_FILES[$name] as $key => $value) {
            $this->{$key} = $value;
        }

        $this->field = $name;
        $destName = ($destName == '') ? $name : $destName;
        $this->uploadFile = $destName . '.' . $this->getExt($this->name);
        $this->uploadDir = $uploadDir;
    }

    /**
     * see php.net form mime type
     * @param type $filename
     * @return string
     */
    function mimeContentType($filename) {

        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = $this->getExt($filename);
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
    }

    public function validate($require = true) {
        if (!is_dir($this->uploadDir)) {
            $this->setError($this->field, $this->errorMessage[0]);
            return false;
        }

        if (count($_FILES) and $require == true) {
            $this->setError($this->field, $this->errorMessage[1]);
            return false;
        } else {
            return true;
        }

        if (!in_array($this->getExt($this->name), $this->allowedTypes) and $this->type == $this->mimeContentType($this->name)) {
            $this->setError($this->field, $this->errorMessage[2]);
            return false;
        }

        return true;
    }

    public function getFileName() {
        return $this->tmp_name != '' ? $this->uploadFile : false;
    }

    private function getExt($file) {
        $file = explode('.', $file);
        $ext = end($file);
        return strtolower($ext);
    }

    public function save() {
        $dest = $this->uploadDir . $this->uploadFile;
        if (move_uploaded_file($this->tmp_name, $dest)) {
            return true;
        } else {
            $this->setError($this->field, $this->errorMessage[0]);
            return false;
        }
    }

    private function setError($name, $errorMsg) {
        $error = Base::instance()->session->flashData('error');
        // if (!isset($error[$name])) {
        $error[$name] = $errorMsg;
        // }
        Base::instance()->session->setFlashData('error', $error);
    }

}
?>


