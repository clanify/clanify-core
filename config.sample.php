<?php
//database configuration.
define('DB_HOST', 'hostname');
define('DB_PORT', 3306);
define('DB_NAME', 'database_name');
define('DB_USER', 'username');
define('DB_PASS', 'password');

//path and url configuration.
define('URL', 'http://clanify.local/');
define('ABSPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('SRCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR);
define('VIEWDIR', SRCPATH.'View'.DIRECTORY_SEPARATOR);

//date and time formatting.
define('FORMAT_DATETIME', 'Y-m-d H:i:s');

//project honeypot key for spam protection.
define('PROJECT_HONEYPOT_KEY', '');
