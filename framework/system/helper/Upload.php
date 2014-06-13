<?php

class Upload {

    private $uploadFile;
    private $name;
    private $tmp_name;
    private $type;
    private $error;
    private $errorMessage = array('1' => 'Invalid upload directory.',
                                  '2' => 'Invalid number of file upload parameters.');
    private $allowedTypes = array
        ('jpg', 'gif', 'png');

    public function __construct($name, $uploadDir, $mime) {

        if (!is_dir($uploadDir)) {

            throw new Exception('Invalid upload directory.');
        }

        if (!count($_FILES)) {

            throw new Exception('Invalid number of file upload parameters.');
        }

        foreach ($_FILES[$name] as $key => $value) {

            $this->{$key} = $value;
        }

        if (!in_array($this->type, $this->allowedTypes)) {

            throw new Exception('Invalid MIME type of target file.');
        }

        $this->uploadFile = $uploadDir . basename($this->name);
    }

// upload target file to specified location

    public function save() {

        if (move_uploaded_file($this->tmp_name, $this->uploadFile)) {

            return true;
        }

// throw exception according to error number

        switch ($this->error) {

            case 1:

                throw new Exception('Target file exceeds maximum allowed size.');

                break;

            case 2:

                throw new Exception('Target file exceeds the MAX_FILE_SIZE value specified on the upload form.');

                break;

            case 3:

                throw new Exception('Target file was not uploaded completely.');

                break;

            case 4:

                throw new Exception('No target file was uploaded.');

                break;

            case 6:

                throw new Exception('Missing a temporary folder.');

                break;

            case 7:

                throw new Exception('Failed to write target file to disk.');

                break;

            case 8:

                throw new Exception('File upload stopped by extension.');

                break;
        }
    }

}
?>


