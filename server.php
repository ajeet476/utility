<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

processUri($url);
die(0);

function processUri($url)
{
    switch ($url) {
        CASE "/ping":
        CASE "/ping/":
            sendPong();
            break;

        CASE "/openid/oauth/call":
        CASE "/openid/oauth/call/":
            openIdToken();
            break;

        CASE "/openid/auth":
        CASE "/openid/auth/":
            openIdToken();
            break;

        CASE "/openid/oauth/accesstoken":
        CASE "/openid/oauth/accesstoken/":
            openIdToken();
            break;

        CASE "/openid_api/get_easy_id":
        CASE "/openid_api/get_easy_id/":
            openIdToken();
            break;

        default:
            sendDefault();
    }
}

function sendPong()
{
    $response = ['response' => 'pong'];
    writeJsonResponse($response);
}

function openIdToken()
{

}

function getEasyId()
{

}

function basicInfoOpenId()
{
    $response = [
        "status" => 'OK',
        "response" => [
            "status_code" => "SUCCESS",
            "emailAddress" => "test@abc.net",
            "nickName" => "",
            "firstName" => "",
            "lastName" => "",
            "firstNameKataKana" => "",
            "lastNameKataKana" => "",
            "birthDay" => "1975/02/03",
            "sex" => "mail"
        ]
    ];
    writeJsonResponse($response);
}

function sendDefault()
{
    writeHtml();
}


function writeJsonResponse($response)
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($response);
}

function writexXmlResponse($response)
{
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml; charset=utf-8");
    $xml = new SimpleXMLElement('<root/>');
    array_walk_recursive($response, array ($xml, 'addChild'));
    print $xml->asXML();
}

function writeHtml()
{
    $html = <<<EOL
<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7"><![endif]-->
<!--[if lt IE 9]><html class="no-js lte-ie8"><![endif]-->
<!--[if (gt IE 8)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title>Lists All project available to test</title>
  <meta name="author" content="Ajeet Kumar">
  <meta name="description" content="Stub"> 
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  </head>
<body>
  <div class="container">
    <div class="col-sm-12">
      <h3> Hi, It Works </h3>
   </div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
EOL;

    echo $html;
}

