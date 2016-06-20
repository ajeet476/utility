<?php
function param($name){
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
function printAnchorTag($link, $text){
	echo '<a href="./'.$link.'">'.$text.'</a>';
}
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
function print_all_projects() {
echo '<div class="bs-calltoaction bs-calltoaction-primary">
      <div class="row">
<h3 class="panel-title">All Projects in Localhost</h3>
<ul class="list-group" id="tree1">';
	if ($handle = opendir('.')) {
	
		$count = 1;
	    while (false !== ($entry = readdir($handle))) {
	
			// dir and does not start with . or is . or ..
	        if (substr($entry,0,1)!='.') {
	
	        	if(avoidPrinting($entry)){continue;}
				echo '<li class="list-group-item">';
	            printAnchorTag($entry, $entry);
	            if (is_dir($entry) && $handle2 = opendir('./'.$entry)) {
		            echo '<hr></hr>
	                        <ul class="list-group">';
	            	while (false !== ($entry2 = readdir($handle2))) {
					    if(avoidPrinting($entry.'/'.$entry2)){continue;}
	            		if (substr($entry2,0,1) != ".") {
	            			echo '<li class="list-group-item">';
	            			printAnchorTag($entry.'/'.$entry2, $entry2);
	            			echo "</li>";
	            		}
	            	}
	            	closedir($handle2);
	            	echo '</ul>';
	            }
	            echo '</li>';
	            $count++;
	        }
	    }
	    closedir($handle);
	}
	echo '		</ul>
	</div></div>';
}

function print_html($array){
	$format='<div class="col-md-3"><div class="btn btn-success btn-circle"><i class="fa %s fa-2x"></i></div><p>%s</p></div>';
	foreach ($array as $name){
		$class = 'fa-'.strtolower($name);
		$design = sprintf($format,$class, $name);
		echo $design;
	}
}
function print_opcache($data){
	if(isset($data['restart_pending'])){
		echo 'restart_pending'.$data['restart_pending'].'<br>';
	}
	if(isset($data['scripts'])){
		echo '#scripts: ',count($data['scripts'])."<br>";
		foreach ($data['scripts'] as $script){
			print_r($script["full_path"]);
			echo "<br>";
		}
	}
}
?>
<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7"><![endif]-->
<!--[if lt IE 9]><html class="no-js lte-ie8"><![endif]-->
<!--[if (gt IE 8)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title>Lists All project available to test</title>
  <meta name="author" content="Adrian Mejia">

  
  <meta name="description" content="Sometime;">
  

  <!-- http://t.co/dKP3o1e -->
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
<!-- Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
    <div class="col-sm-12">
      <div class="bs-calltoaction bs-calltoaction-default">
        <div class="row" style="margin-top: 20px">
		    <div class="alert alert-info">
		        <a href="/list.php?list=1" class="btn btn-xs btn-primary pull-right">List It!</a>
		        <strong>List project:</strong> you should do an action.
		    </div>
		
		    <div class="alert alert-warning">
		        <a href="/list.php?extensions=1" class="btn btn-xs btn-warning pull-right">extensions</a>
		        <strong>extensions:</strong> It will list all extensions of PHP
		    </div>
		
		    <div class="alert alert-danger">
		        <a href="/list.php?opcache=clear" class="btn btn-xs btn-danger pull-right">opcache</a>
		        <strong>opcache:</strong> you shouldn't do an action!
    		</div>
		</div>
	</div>	
     <div class="bs-calltoaction bs-calltoaction-info">
        <div class="row"><h3 class="page-title text-center">
        	  <?php	  echo 'phpversion():<span class="label label-info">'.phpversion();?>
        </span></h3></div>
     </div>  	  
	  <?php  
	if (param('list'))
	{
		print_all_projects();
	}
	


  if (param('extensions'))
  {
  	echo '<div class="bs-calltoaction bs-calltoaction-warning">
          <div class="row">';
  	  print_html(get_loaded_extensions());
  	echo '</div></div>';
  }
  if (param('opcache')&&param('opcache')=='clear')
  {
  	echo '<div class="bs-calltoaction bs-calltoaction-warning">
          <div class="row">';
  	echo '<PRE><p class="btn btn-lg btn-block btn-primary">before</p><br>';
  	echo print_opcache(opcache_get_status());
  	opcache_reset();
  	echo '<PRE><p class="btn btn-lg btn-block btn-primary">after</p><br>';
  	echo print_opcache(opcache_get_status());
  	echo '</div></div>';
  }
  
   ?>
</div></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="tree.js"></script>	
</body>
</html>
