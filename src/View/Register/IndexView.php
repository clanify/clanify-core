<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\CitoEngine;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();
$logo = URL.'src/View/templates/public/img/clanify-logo.png';

//set the head information of the site.
$title = 'Clanify - Organize Clans, eSport-Teams and Gaming-Communities.';
$description = 'Clanify is a tool to organize Clans, eSport-Teams and Gaming-Communities.';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$clanifyJS = URL.'src/View/templates/public/js/clanify.js';

//set the header content.
$cito->setValue('head', '<meta charset="utf-8">');
$cito->setValue('head', '<meta http-equiv="X-UA-Compatible" content="IE=edge">');
$cito->setValue('head', '<meta name="viewport" content="width=device-width, initial-scale=1">');
$cito->setValue('head', '<title>'.$title.'</title>');
$cito->setValue('head', '<meta name="description" content="'.$description.'"/>');
$cito->setValue('head', '<meta name="keywords" content="clanify, gaming, clan, esport"/>');
$cito->setValue('head', '<link href="'.CDN::getNormalizeCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.CDN::getBootstrapCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.CDN::getAnimateCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.CDN::getFontNunitoCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.$stylesheet.'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>');
$cito->setValue('head', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>');
?>
<div id="register">
    <div class="overlay"></div>
    <div class="container">
        <div class="row header">
            <div class="col-md-12" id="logo">
                <a href="<?= URL ?>">
                    <img class="logo animated fadeInLeft" src="<?= $logo ?>" alt="Clanify Logo">
                </a>
            </div>
        </div>
        <div class="row content">
            <div class="col-sm-7">
                <h1 class="animated fadeInDown">Clans. Gaming-Communities.<br/>
                    eSport-Teams.<br/><br/>
                    Organize with Clanify!
                </h1>
            </div>
            <div class="col-sm-5">
                <form class="ajax" method="post" data-action="<?= URL ?>register/register">
                    <div class="alert" role="alert"></div>
                    <div class="form-group">
                        <label class="sr-only" for="email">E-Mail</label>
                        <input type="text" name="register_email" placeholder="E-Mail" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="username">Username</label>
                        <input type="text" name="register_username" placeholder="Username" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="register_password" placeholder="Password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn btn-success">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>