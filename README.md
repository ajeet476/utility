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

#### Multiple hosts setting


```php
// File external/header.php
// add this code around Line 130

        // for multiple hosts
        // prepend ServerName in URI
        if (array_key_exists('SERVER_NAME', $_SERVER)) {
            $uri = $_SERVER['SERVER_NAME'] . $uri;
        }
```

