<?php
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\Template\CDN;
use Clanify\Core\CitoEngine;
use Clanify\Core\Database;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();
$logo = URL.'src/View/templates/public/img/clanify-logo.png';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$favicon = URL.'src/View/templates/public/img/favicon.ico';
$menuBuilder = new MenuBuilder(Database::getInstance()->getConnection());

//set the head information of the site.
$title = 'Clanify - Organize Clans, eSport-Teams and Gaming-Communities.';
$description = 'Clanify is a tool to organize Clans, eSport-Teams and Gaming-Communities.';

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
$cito->setValue('head', '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'"/>');
$cito->setValue('backend_menu', $menuBuilder->getMenu('backend'));
$cito->setValue('backend_menu_user', $menuBuilder->getMenu('backend_user'));
$cito->setValue('username', $_SESSION['user_username']);
$cito->setValue('logo', URL.'src/View/templates/public/img/clanify-logo.png');
$cito->setValue('base_url', URL.'dashboard');

//set the footer content.
$cito->setValue('footer', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('footer', '<script src="'.CDN::getBootstrapJS().'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg"');
?>
<div class="container" id="team-edit">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="jumbotron alert-danger">
                <h2>Willkommen</h2>
                <p>
                    Dies ist eine Demo! Hier kannst du alle Funktionen testen und dir einen ersten Eindruck
                    verschaffen. Da es sich hier nur um eine Demo handelt, verwende keine persönlichen Informationen.
                    Alle Informationen welche du hier angibst können von jedem gesehen werden, der diese Demo ebenfalls
                    testet.
                </p>
                <h2>Feedback</h2>
                <p>
                    Du hast eine Fehler gefunden? Es funktioniert etwas nicht? Du hast neue Ideen? Schreibe einfach
                    eine kurze E-Mail an: <a href="mailto:hello@clanify.rocks">hello@clanify.rocks</a>
                </p>
            </div>
        </div>
    </div>
</div>