<?php

function getParam($name){
  if(is_string($name)){
    if((bool) get_magic_quotes_gpc()){
    set_magic_quotes_runtime(0);
    $param = isset($_POST[$name]) ? stripslashes($_POST[$name]) : false;
    $param = isset($_GET[$name]) ? stripslashes($_GET[$name]) : $param;
      }else{
    $param = isset($_POST[$name]) ? $_POST[$name] : false;
    $param = isset($_GET[$name]) ? $_GET[$name] : $param;
      }
      return $param;
    }else{
    return $name;
  }
}
echo phpversion();

function avoidPrinting($dir){
  if(is_dir($dir)){
    $last = end(explode(DIRECTORY_SEPARATOR,$dir));
    if(in_array($last , array('app' ,'config','vendor','.git','nbproject' ))){
      return true;
    }
  }
  if( is_file($dir) ){
    $last = end(explode(DIRECTORY_SEPARATOR,$dir));
    if(strpos($last, '.php')===false){
      return true;
    }
  }
  return false;
}

function listFolderFiles($dir, $depth){
    if($depth == 0){
      return 0;
    }
    if(avoidPrinting($dir)){return;}
    $ffs = scandir($dir);
    echo '<ul>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            if(avoidPrinting($dir.'/'.$ff)){continue;}
            echo '<li class="media">
            <a class="media-left" href="'.$dir.'/'.$ff.'">
              <span class="glyphicon glyphicon-user icon text-success"></span>
            '.$ff.'</a>';
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff, $depth-1);
            echo '</li>';
        }
    }
    echo '</ul>';
}

function getAllFolderWithStyle(){
  echo '<section class="section">
      <div class="container">
          <div class="row">
                <div class="content">
                  <div class="pull-middle">
                          <h2 class="h1 page-header">Discover about Projects.</h2>
                  </div><ul id="tree1">';
                  listFolderFiles('.',2);
        echo '      </ul></div>
          </div>
      </div>
  </section>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        .header {
    padding-top: 50px;
    background-color: #eee;
    overflow: hidden;
}
.footer {
    color: #887;
    background-color: #eee;
    padding-top: 30px;
    padding-bottom: 30px;
}

.content {
    position: relative;
    display: table;
    width: 100%;
}
.tree, .tree ul {
    margin:0;
    padding:0;
    list-style:none
}
.tree ul {
    margin-left:1em;
    position:relative
}
.tree ul ul {
    margin-left:.5em
}
.tree ul:before {
    content:"";
    display:block;
    width:0;
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    border-left:1px solid
}
.tree li {
    margin:0;
    padding:0 1em;
    line-height:2em;
    color:#369;
    font-weight:700;
    position:relative
}
.tree ul li:before {
    content:"";
    display:block;
    width:10px;
    height:0;
    border-top:1px solid;
    margin-top:-1px;
    position:absolute;
    top:1em;
    left:0
}
.tree ul li:last-child:before {
    background:#fff;
    height:auto;
    top:1em;
    bottom:0
}
.indicator {
    margin-right:5px;
}
.tree li a {
    text-decoration: none;
    color:#369;
}
.tree li button, .tree li button:active, .tree li button:focus {
    text-decoration: none;
    color:#369;
    border:none;
    background:transparent;
    margin:0px 0px 0px 0px;
    padding:0px 0px 0px 0px;
    outline: 0;
}
    </style>
</head>
<body id="app-layout">
  <div class="wrapper">
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand text-uppercase" href="#">Curve App <span class="label label-success text-capitalize">Free</span></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navigation">
              <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">About</a></li>
                  <li><a href="#">Features</a></li>
                  <li><button type="button" class="btn btn-success navbar-btn btn-circle">Sign in</button></li>
              </ul>
          </div>
        </div>
      </nav>
      <header class="header">
          <div class="container">
            <div class="row">
                <div class="content">
                  <div class="alert alert-info">
                      <a href="?list=1" class="btn btn-xs btn-primary pull-right">List All Projects</a>
                      <strong>Info:</strong> you should do an action.
                  </div>

                  <div class="alert alert-warning">
                      <a href="?extensions=1" class="btn btn-xs btn-warning pull-right">List All extensions</a>
                      <strong>Warning:</strong> you should do an action.
                  </div>

                  <div class="alert alert-danger">
                      <a href="?opcache=clear" class="btn btn-xs btn-danger pull-right">Clear OpCache</a>
                      <strong>Danger:</strong> you shouldn't do an action!
                  </div>
              </div>
            </div>
          </div>
      </header>
      <?php if(getParam('list')){ getAllFolderWithStyle(); } ?>
      <footer class="footer text-center">
          <div class="container">
              <small>© Copyright 2015. Crafted with love by <a href="https://www.twitter.com/maridlcrmn">@maridlcrmn</a></small>
          </div>
      </footer>
  </div>
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="tree.js"></script>
</body>
</html>
