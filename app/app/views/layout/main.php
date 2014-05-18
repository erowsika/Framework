<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- boostrap CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo App::instance()->base_url ?>assets/css/bootstrap.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo App::instance()->base_url ?>assets/css/bootstrap-theme.min.css" media="print" />
        <link href="<?php echo App::instance()->base_url ?>assets/docs/css/docs.min.css" rel="stylesheet">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo App::instance()->base_url ?>assets/docs/ico/apple-touch-icon-144-precomposed.png">
        <link rel="shortcut icon" href="<?php echo App::instance()->base_url ?>assets/docs/ico/favicon.ico">
        <title><?php echo App::instance()->title ?></title>
    </head>
    <body class="bs-docs-home">
        <?php
        echo $this->outputHtml('layout\menu.php');
        echo $content;
        echo $this->outputHtml('layout\footer.php');
        ?>

        <script src="<?php echo App::instance()->base_url ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo App::instance()->base_url ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo App::instance()->base_url ?>assets/docs/js/docs.min.js"></script>
    </body>
</html>
