<?php
//include the configuration.
require_once('config.php');

//include the autoloader.
require_once(SRCPATH.'Autoloader.php');

//initialize the autoloader.
$auto_loader = new \Clanify\Autoloader();
$auto_loader->addNamespace('Clanify', 'src');

//initialize the template engine.
$cito = \Clanify\Core\CitoEngine::getInstance();
$cito->init();

//initialize the application.
$clanify = new \Clanify\Core\Clanify();

//render the output.
$cito->render();
