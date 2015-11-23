<?php
//include the autoloader.
require_once('../src/Autoloader.php');

//initialize the autoloader.
$auto_loader = new \Clanify\Autoloader();
$auto_loader->addNamespace('Clanify', '../src');

//initialize the application.
$clanify = new \Clanify\Core\Clanify();
