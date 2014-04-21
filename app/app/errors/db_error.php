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
                font-size: 14px;
                padding-bottom:20px;
            }
            .error-code{
                font-family: 'Creepster', cursive, arial, helvetica, sans-serif;
                font-size: 200px;
                color: white;
                color: rgba(255, 255, 255, 0.98);
                width: 50%;
                text-align: right;
                margin-top: 5%;
                text-shadow: 5px 5px hsl(0, 0%, 25%);
                float: left;
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
                color: #9ECDFF;
                text-shadow: 0px 0px 2px white;
            }
            a:hover{
                color:white;
            }

        </style>
        <title></title>
    </head>
    <body>


        <div class="clear"></div>
        <div class="content">
            <div style="border: 1px solid;
                 margin: 10px 0px;
                 padding:15px 10px;
                 background-repeat: no-repeat;
                 background-position: 10px center;-moz-border-radius:.5em;
                 -webkit-border-radius:.5em;
                 color: #D8000C;
                 border-radius:.5em;">
                <h4>Database error</h4>
                <?php echo $message ?>
            </div>
        </div>
    </body>
</html>
