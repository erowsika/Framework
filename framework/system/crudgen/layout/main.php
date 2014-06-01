<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Code and CRUD Generator</title>
        <link href="<?php echo \system\core\Base::instance()->base_url ?>assets/bootsrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo \system\core\Base::instance()->base_url ?>assets/bootsrap/js/jquery.min.js"></script>
        <style>
            /*
 * Base structure
 */

            /* Move down content because we have a fixed navbar that is 50px tall */
            body {
                padding-top: 50px;
            }


            /*
             * Global add-ons
             */

            .sub-header {
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
            }

            /*
             * Top navigation
             * Hide default border to remove 1px line.
             */
            .navbar-fixed-top {
                border: 0;
            }

            /*
             * Sidebar
             */

            /* Hide for mobile, show later */
            .sidebar {
                display: none;
            }
            @media (min-width: 768px) {
                .sidebar {
                    position: fixed;
                    top: 51px;
                    bottom: 0;
                    left: 0;
                    z-index: 1000;
                    display: block;
                    padding: 20px;
                    overflow-x: hidden;
                    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
                    background-color: #f5f5f5;
                    border-right: 1px solid #eee;
                }
            }

            /* Sidebar navigation */
            .nav-sidebar {
                margin-right: -21px; /* 20px padding + 1px border */
                margin-bottom: 20px;
                margin-left: -20px;
            }
            .nav-sidebar > li > a {
                padding-right: 20px;
                padding-left: 20px;
            }
            .nav-sidebar > .active > a,
            .nav-sidebar > .active > a:hover,
            .nav-sidebar > .active > a:focus {
                color: #fff;
                background-color: #428bca;
            }


            /*
             * Main content
             */

            .main {
                padding: 20px;
            }
            @media (min-width: 768px) {
                .main {
                    padding-right: 40px;
                    padding-left: 40px;
                }
            }
            .main .page-header {
                margin-top: 0;
            }


            /*
             * Placeholder dashboard ideas
             */

            .placeholders {
                margin-bottom: 30px;
                text-align: center;
            }
            .placeholders h4 {
                margin-bottom: 0;
            }
            .placeholder {
                margin-bottom: 20px;
            }
            .placeholder img {
                display: inline-block;
                border-radius: 50%;
            }

        </style>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo \system\core\Base::instance()->base_url. $_SERVER['PATH_INFO'] ?>">Code Generator</a>
                </div>
            </div>
        </div>
        <?php echo $content;  ?>
    </body>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo \system\core\Base::instance()->base_url ?>assets/bootsrap/js/bootstrap.min.js"></script>
</html>
