<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <style>
            *{
                margin:0;
                padding:0;
            }
            body{
                font-family: 'Audiowide', cursive, arial, helvetica, sans-serif;
                color:black;
                font-size: 18px;
                padding-bottom:20px;
            }
            .error-code{
                font-family: 'Audiowide', cursive, arial, helvetica, sans-serif;
            }
            .not-found{
                width: 47%;
                float: right;
                margin-top: 5%;
                font-size: 50px;
                color: white;
                text-shadow: 2px 2px 5px hsl(0, 0%, 61%);
                padding-top: 70px;
            }
            .clear{
                float:none;
                clear:both;
            }
            .content{
                line-height: 30px;
            }
            input[type=text]{
                border: hsl(247, 89%, 72%) solid 1px;
                outline: none;
                padding: 5px 3px;
                font-size: 16px;
                border-radius: 8px;
            }
            a{
                text-decoration: none;
                text-shadow: 0px 0px 2px white;
            }
            a:hover{
                color:white;
            }

        </style>
        <title></title>
    </head>
    <body>

        <h2 style="color: #D8000C;">A PHP Error was encountered</h2>
        <div class="clear"></div>
        <div class="content">
            <div style="border: 1px solid;
                 margin: 10px 0px;
                 padding:15px 10px;
                 background-repeat: no-repeat;
                 background-position: 10px center;-moz-border-radius:.5em;
                 -webkit-border-radius:.5em;
                 border-radius:.5em;">

                <p style="color: #D8000C;">Message:  <?php echo $message ?></p>
                <p style="color: #D8000C;">Filename: <?php echo $file ?></p>
                <p style="color: #D8000C;">Line Number: <?php echo $line ?></p>
                <p class="error-code">Position : <br> <?php echo $code ?></p>    
            </div>";
        </div>
    </body>
</html>
