<?php
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\Template\CDN;
use Clanify\Domain\Entity\Team;
use Clanify\Core\CitoEngine;
use Clanify\Core\Template\FormBuilder;
use Clanify\Core\Database;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();
$logo = URL.'src/View/templates/public/img/clanify-logo.png';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$clanifyJS = URL.'src/View/templates/public/js/clanify.js';
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
$cito->setValue('head', '<link href="'.CDN::getFontAwesomeCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'"/>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>');
$cito->setValue('backend_menu', $menuBuilder->getMenu('backend'));
$cito->setValue('backend_menu_user', $menuBuilder->getMenu('backend_user'));
$cito->setValue('username', $_SESSION['user_username']);
$cito->setValue('logo', URL.'src/View/templates/public/img/clanify-logo.png');
$cito->setValue('base_url', URL.'dashboard');

//set the footer content.
$cito->setValue('footer', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('footer', '<script src="'.CDN::getBootstrapJS().'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="team-edit"');
$teams = $this->getVar('teams', []);
?>
<div class="container" id="team-index">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Teams</h2>
            <?php if (count($teams) > 0) : ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Tag</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($teams as $team) : ?>
                        <?php if ($team instanceof Team) : ?>
                            <tr onclick="document.location = '<?= URL ?>team/edit/<?= $team->id ?>';">
                                <td><?= $team->name ?></td>
                                <td><?= $team->tag ?></td>
                                <td onclick="preventOnClick()">
                                    <?php if ($team->website !== '') : ?>
                                        <a target="_blank" href="<?= $team->website ?>"><?= $team->website ?></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pull-right">
                    <?= FormBuilder::getButtonNew(URL.'team/create'); ?>
                </div>
            <?php else : ?>
                <div class="alert alert-warning" role="alert">
                    No Team available! -
                    <a href="<?= URL ?>team/create/" class="alert-link">Create a Team.</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>