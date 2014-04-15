<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- boostrap CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Sby::instance()->base_url ?>assets/css/bootstrap.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Sby::instance()->base_url ?>assets/css/bootstrap-theme.min.css" media="print" />
        <title><?php echo Sby::instance()->title ?></title>
    </head>
    <body>
        <div class="container">

            <?php
            echo $content
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="<?php echo Sby::instance()->base_url ?>assets/js/bootstrap.min.js"></script>
    </body>
</html>
