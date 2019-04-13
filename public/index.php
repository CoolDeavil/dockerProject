<?php

define('APP_ASSET_BASE', "http://$_SERVER[HTTP_HOST]/");
define('APP_ASSET_BASE_PORT', "http://$_SERVER[HTTP_HOST]");

$styles = '<style>
            body {
                font-family: Consolas, sans-serif;
                color: #ffffff;
            }
            .center {
                position: absolute;
                min-width: 80%;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -60%);

                padding: 20px;
                background-color: #494949;
                border-radius: 7px;

                -webkit-box-shadow: 10px 10px 5px 0 rgba(0,0,0,0.75);
                -moz-box-shadow: 10px 10px 5px 0 rgba(0,0,0,0.75);
                box-shadow: 10px 10px 5px 0 rgba(0,0,0,0.75);
            }
            h4, h3 , h2{
                /*text-align: center;*/
                margin: 0;
            }
            i  {
                font-weight: bolder;
                color: #47b271

            }
            strong {
                color: #4cff2c;
            ;
            }
            .listLinks {
                list-style: none;
                display: flex;
                flex-direction: row;
            }
            .listLinks li {
                flex-grow: 1;
                text-align: center;
            }

            fieldset   {
                border-color: #47b271;
                margin-bottom: 1rem;
                color: #c0c0c0;
                padding: 10px;
            }
            fieldset legend {
                padding: 10px;
                color: #ffffff
            }
            .btn {
                padding: 7px 15px 7px 15px;
                text-decoration: none;
                /*font-weight: bolder;*/
                font-size: 1rem;
                text-align: center;
                background-color: #47b271;
                color: #ffffff;
                /*color: #47b271;*/
                border-radius: 3px;
            }
            a {
                color: #ffffff;
                text-decoration: none;
            }
</style>';


if(isset($_GET['intent'])){
    switch ($_GET['intent']){
        case 'mainLanding';
            render_main($styles);
        break;
        case 'PHP_INFO';
            renderPHPInfo();
        break;
        case 'TEST_EMAIL';
            sendTestEMail();
        break;
        case 'SENT_TEST_MAIL';
            renderEMailWasSent($styles);
        break;
    }
}else{
    render_main($styles);
}

function render_main($styles){
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Site Root</title>
        <?=$styles?>
    </head>
    <body>
    <div class="center">
        <h2><i>Server </i>Apache2 FPM/FastCGI</h2>
        <h3><i>PHP </i><?=phpversion()?></h3>
        <h4><i>Synchronized Folder: </i>/var/www/html/application/public <strong>::</strong> /public</h4>
        <hr>
        <br>
        <fieldset>
            <legend>MySql Database Credentials</legend>
            <ul style="margin: 0;padding: 0; list-style: none">
                <li>
                    Database User <strong>root</strong>
                </li>
                <li>
                    Root Password <strong>root</strong>
                </li>
            </ul>
        </fieldset>

        <fieldset style="opacity: 0.2">
            <legend>mySql SSH Tunnel Credentials:</legend>
            <ul style="margin: 0;padding: 0; list-style: none">
                <li>
                    ssh Port <strong>22</strong>
                </li>
                <li>
                    ssh IP <strong>172.16.237.14</strong> <small>[#] defined on docker-compose ( config.vm.network )</small>
                </li>
                <li>
                    ssh User <strong>vagrant</strong>
                </li>
                <li>
                    ssh Password <strong>vagrant</strong>
                </li>
            </ul>
        </fieldset>


        <fieldset>
            <legend>Developer VM Links:</legend>
            <ul class="listLinks">
                <li><a class="btn" href="http://localhost:8080" target="_blank">PhpMyAdmin</a></li>
                <li><a class="btn"  href="<?= APP_ASSET_BASE_PORT?>:1080" target="_blank">MailCatcher</a></li>
                <li><a class="btn"  href="<?= APP_ASSET_BASE?>?intent=PHP_INFO" target="_blank">PHP Info</a></li>
                <li><a class="btn"  href="<?= APP_ASSET_BASE?>?intent=TEST_EMAIL" target="_blank">Send Test Email</a></li>
            </ul>
        </fieldset>
    </div>
    </body>
    </html>
    <?php
}
function renderPHPInfo(){
    echo "<style>.btn {
            padding: 10px;
            margin-top: 10px;
            text-decoration: none;
            text-align: center;
            background-color: #808080;
            color: #ffffff;
            border-radius: 7px;
        }</style>";
    echo "<br><a href='".APP_ASSET_BASE."' class='btn'>Back</a><br>";
    phpinfo();
}
function renderEMailWasSent($styles){
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Test Email</title>
        <?=$styles?>
    </head>
    <body>
    <div class="center" style="text-align: center">
        &emsp;<span style="font-size: 2rem;color: #ffffff">&#11088;</span>
        <span>Test EMail Sent, check it with <a href='<?=APP_ASSET_BASE_PORT?>:1080'><i>MailCatcher</i></a></span>
    </div>
    <a class="btn" href="<?=APP_ASSET_BASE?>">Back</a>
    </body>
    </html>
    <?php
    exit();
}
function sendTestEMail(){
    $from = "webmaster@site.domain";
    $to = "john_doe@somemail.com";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    header('location: ' . "http://$_SERVER[HTTP_HOST]?intent=SENT_TEST_MAIL");
}
