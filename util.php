
<?php

/**
 * Class Util
 */
class Util
{
    /**
     * Util constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param int $depth
     * @return array
     */
    public function findAllHtmlFiles($depth = 5)
    {
        $format = ['html', 'xhtml'];
        return $this->findAllFiles('./phpunit', $depth, $format);
    }

    /**
     * @param $response
     */
    public function writeJsonResponse($response)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * @param $response
     */
    public function writexXmlResponse($response)
    {
        header('Access-Control-Allow-Origin: *');
        header("Content-type: text/xml; charset=utf-8");
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($response, array($xml, 'addChild'));
        print $xml->asXML();
    }

    public function htmlHeader()
    {
        $html = <<<EOL
<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7"><![endif]-->
<!--[if lt IE 9]><html class="no-js lte-ie8"><![endif]-->
<!--[if (gt IE 8)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title>Local|Ajeet</title>
  <meta name="author" content="Ajeet Kumar">
  <meta name="description" content="Stub"> 
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/favicon.ico" type="image/x-icon" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<style>
.tree ul li:before,.tree ul:before{content:"";display:block;left:0}.tree,.tree ul{margin:0;padding:0;list-style:none}.tree ul{margin-left:1em;position:relative}.tree ul ul{margin-left:.5em}.tree ul:before{width:0;position:absolute;top:0;bottom:0;border-left:1px solid}.tree li{margin:0;padding:0 1em;line-height:2em;color:#369;font-weight:700;position:relative}.tree ul li:before{width:10px;height:0;border-top:1px solid;margin-top:-1px;position:absolute;top:1em}.tree ul li:last-child:before{background:#fff;height:auto;top:1em;bottom:0}.indicator{margin-right:5px}.tree li a{text-decoration:none;color:#369}.tree li button,.tree li button:active,.tree li button:focus{text-decoration:none;color:#369;border:none;background:0 0;margin:0;padding:0;outline:0}
</style>
  </head>
<body>
  <div class="container">
    <div class="col-sm-12">

EOL;

        echo $html;
    }

    /**
     *
     */
    function htmlFooter()
    {
        $html = <<<EOL

   </div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/js/tree.js" crossorigin="anonymous"></script>
</body>
</html>
EOL;

        echo $html;
    }

    /**
     * @param string $baseDir
     * @param int $depth
     * @param array $fileFormat
     * @return array
     */
    public function findAllFiles($baseDir = '.', $depth = 5, $fileFormat = [])
    {
        if (empty($baseDir) or $depth < 0) {
            return [];
        }

        $handler = opendir($baseDir);

        if (empty($handler)) {
            return [];
        }

        $ret = [];
        while ($entry = readdir($handler)) {
            // skip current or parent
            if (in_array($entry, ['.', '..'])) {
                continue;
            }

            $fullPath = $baseDir . DIRECTORY_SEPARATOR . $entry;

            if (is_dir($fullPath)) {
                $ret[$entry] = $this->findAllFiles($fullPath, $depth - 1, $fileFormat);
            } elseif ($this->validFile($fullPath, $fileFormat)) {
                $ret[] = $fullPath;
            }
        }

        return $ret;
    }

    /**
     * @param $allFiles
     * @param int $label
     */
    public function printTree($allFiles, $label = 1)
    {
        if (empty($allFiles)) {
            return;
        }

        echo '<ul class="list-group" id="tree' . $label . '">';

        foreach ($allFiles as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if (is_string($key)) {
                echo "<span class='list-group-item'> $key </span>";
                $this->printTree($value, $label + 1);
            } else {
                echo '<li class="list-group-item">';
                echo "<a href='$value'> {$value} </a>";
                echo "</li>";
            }
        }
        echo '</ul>';
    }

    /**
     * @param $filename
     * @param $fileFormat
     * @return bool
     */
    public function validFile($filename, $fileFormat)
    {
        if (!is_file($filename)) {
            return false;
        }
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($extension, $fileFormat)) {
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * @return bool|string
     */
    public function param($name)
    {
        if (is_string($name)) {
            if ((bool)get_magic_quotes_gpc()) {
                $param = isset($_POST[$name]) ? stripslashes($_POST[$name]) : false;
                $param = isset($_GET[$name]) ? stripslashes($_GET[$name]) : $param;
            } else {
                $param = isset($_POST[$name]) ? $_POST[$name] : false;
                $param = isset($_GET[$name]) ? $_GET[$name] : $param;
            }
            return $param;
        } else {
            return $name;
        }
    }
}

class Index
{
    /**
     * @var mixed
     */
    private $url;

    /**
     * @var Util
     */
    private $util;

    /**
     * Index constructor.
     * @param Util $util
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     *
     */
    public function execute()
    {
        $this->processUri();
    }

    /**
     * @return bool
     */
    private function processUri()
    {
        switch ($this->url) {
            CASE "/ping":
            CASE "/ping/":
                $this->sendPong();
                break;

            CASE "/openid/oauth/call":
            CASE "/openid/oauth/call/":
                $this->openIdToken();
                break;

            CASE "/openid/auth":
            CASE "/openid/auth/":
                $this->openIdToken();
                break;

            CASE "/openid/oauth/accesstoken":
            CASE "/openid/oauth/accesstoken/":
                $this->openIdToken();
                break;

            CASE "/openid_api/get_easy_id":
            CASE "/openid_api/get_easy_id/":
                $this->openIdToken();
                break;

            default:
                $this->sendDefault();
        }
        return true;
    }

    private function sendPong()
    {
        $response = ['response' => 'pong'];
        $this->util->writeJsonResponse($response);
    }

    private function openIdToken()
    {

    }

    private function getEasyId()
    {

    }

    private function basicInfoOpenId()
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
        $this->util->writeJsonResponse($response);
    }

    private function sendDefault()
    {
        $this->util->htmlHeader();
        echo "<h2> It Works!! </h2>";
        echo "<h4 class='footer'> <a href='tests.php' > PHPUnit Test Cases </a></h4>";
        $this->util->htmlFooter();
    }
}
