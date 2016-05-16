<?php
use Clanify\Core\CitoEngine;
use Clanify\Core\Template\CDN;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();

//set the stylesheets and images.
$favicon = URL.'src/View/templates/public/img/favicon.ico';
$logo = URL.'src/View/templates/public/img/clanify-logo.png';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$email = 'mailto:hello@clanify.rocks?subject=Hello';

//set the head information of the site.
$title = 'Clanify - Organize Clans, Gaming-Communities and eSport-Teams.';
$description = 'Clanify is a tool to organize Clans, Gaming-Communities and eSport-Teams.';
$keywords = 'clanify, gaming, clan, esport';

//set the header content.
$cito->setValue('head', '<meta charset="utf-8">');
$cito->setValue('head', '<meta http-equiv="X-UA-Compatible" content="IE=edge">');
$cito->setValue('head', '<meta name="viewport" content="width=device-width, initial-scale=1">');
$cito->setValue('head', '<title>'.$title.'</title>');
$cito->setValue('head', '<meta name="description" content="'.$description.'"/>');
$cito->setValue('head', '<meta name="keywords" content="'.$keywords.'"/>');
$cito->setValue('head', '<link href="'.CDN::getNormalizeCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.CDN::getBootstrapCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.CDN::getAnimateCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.CDN::getFontNunitoCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.$stylesheet.'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'"/>');

//set the footer content.
$cito->setValue('footer', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('footer', '<script src="'.CDN::getBootstrapJS().'"></script>');
?>
<div class="overlay"></div>
<div class="container">
    <div class="row header">
        <div class="col-md-12">
            <a href="<?= URL ?>">
                <img class="animated fadeInLeft" src="<?= $logo ?>" alt="Clanify Logo">
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <h1 class="animated fadeInDown large">Clans. Gaming-Communities. eSport-Teams.<br/>
                Organize with Clanify!
            </h1>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <p class="animated fadeInDown">Clanify befindet sich momentan noch in der Entwicklung.
                Doch du hast die Möglichkeit deine Ideen und Erfahrungen zur Organisation von Clans,
                eSport-Teams oder Gaming-Communities einzubringen.
            </p>
            <div class="col-md-6 col-md-offset-3 col-sm-12 animated fadeInDown">
                <a class="btn btn-success btn-lg center-block" href="<?= $email ?>">hello@clanify</a>
            </div>
        </div>
    </div>
</div>
