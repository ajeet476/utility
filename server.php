<?php
/*
Rewrite using .htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
*/

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'util.php';



$index = new Index(new Util());

$index->execute();
die(0);
