<?php
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\Template\CDN;
use Clanify\Domain\Entity\Clan;
use Clanify\Core\CitoEngine;
use Clanify\Core\Template\FormBuilder;
use Clanify\Core\Database;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();
$logo = URL.'src/View/templates/public/img/clanify-logo.png';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$favicon = URL.'src/View/templates/public/img/favicon.ico';
$clanifyJS = URL.'src/View/templates/public/js/clanify.js';
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
$cito->setValue('head', '<link href="'.CDN::getFontAwesomeCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'"/>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>"');
$cito->setValue('backend_menu', $menuBuilder->getMenu('backend'));
$cito->setValue('backend_menu_user', $menuBuilder->getMenu('backend_user'));
$cito->setValue('username', $_SESSION['user_username']);
$cito->setValue('logo', URL.'src/View/templates/public/img/clanify-logo.png');
$cito->setValue('base_url', URL.'dashboard');

//set the footer content.
$cito->setValue('footer', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('footer', '<script src="'.CDN::getBootstrapJS().'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="clan-index"');
$clans = $this->getVar('clans', []);
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Clans / Communities</h2>
            <?php if (count($clans) > 0) : ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Tag</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($clans as $clan) : ?>
                        <?php if ($clan instanceof Clan) : ?>
                            <tr onclick="document.location = '<?= URL ?>clan/edit/<?= $clan->id ?>';">
                                <td><?= $clan->name ?></td>
                                <td><?= $clan->tag ?></td>
                                <td onclick="preventOnClick()">
                                <?php if ($clan->website !== '') : ?>
                                    <a target="_blank" href="<?= $clan->website ?>"><?= $clan->website ?></a>
                                <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pull-right">
                    <?= FormBuilder::getButtonNew(URL.'clan/create') ?>
                </div>
            <?php else : ?>
                <div class="alert alert-warning" role="alert">
                    No Clans / Communities available! -
                    <a href="<?= URL ?>clan/create/" class="alert-link">Create a Clan / Community.</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
