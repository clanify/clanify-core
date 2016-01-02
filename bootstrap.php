<?php
//define the source directory of the project.
define('PROJECT_SRC', __DIR__);

//include the autoloader.
require_once(PROJECT_SRC.'/src/Autoloader.php');

//initialize the autoloader for the project source.
$autoloader = new \Clanify\Autoloader();
$autoloader->addNamespace('\Clanify', PROJECT_SRC.'/src');
$autoloader->addNamespace('\Clanify\Test', PROJECT_SRC.'/test');
