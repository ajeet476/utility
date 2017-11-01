# utility



# xhgui configuration

### with htaccess
    php_value auto_prepend_file "/var/www/html/local.xhgui.jp/external/header.php"
### with apache vhost
    php_admin_value auto_prepend_file "/var/www/html/local.xhgui.jp/external/header.php"

### with index.php
    require_once "/var/www/html/local.xhgui.jp/external/header.php";
    
### with nginx
    fastcgi_param PHP_VALUE "auto_prepend_file=/var/www/html/local.xhgui.jp/external/header.php";

