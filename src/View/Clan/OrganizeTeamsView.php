<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\CitoEngine;
use Clanify\Core\Template\FormBuilder;
use Clanify\Domain\Entity\Clan;
use Clanify\Domain\Entity\Team;
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
$cito->setValue('backend_menu', $menuBuilder->getMenu('backend'));
$cito->setValue('backend_menu_user', $menuBuilder->getMenu('backend_user'));
$cito->setValue('username', $_SESSION['user_username']);
$cito->setValue('logo', URL.'src/View/templates/public/img/clanify-logo.png');
$cito->setValue('base_url', URL.'dashboard');

//set the footer content.
$cito->setValue('head', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>');
$cito->setValue('head', '<script src="'.CDN::getBootstrapJS().'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="clan-edit"');
$clan = $this->getVar('clan', new Clan());
$teams = $this->getVar('teams', []);
$clanTeams = $this->getVar('clan_teams', []);
?>
<div class="container" id="clan-edit">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="hide-text-overflow">Organize Team</h2>
            <div class="alert alert-info pill-bar">
                <ul class="nav nav-pills">
                    <li class="active"><a data-target="#not-assigned" data-toggle="tab">Not Assigned</a></li>
                    <li><a data-target="#assigned" data-toggle="tab">Assigned</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="not-assigned">
                    <form action="<?= URL ?>clan/team-add/<?= $clan->id ?>" method="post">
                        <?php if (count($teams) > 0) : ?>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Tag</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($teams as $team) : ?>
                                    <?php if ($team instanceof Team) : ?>
                                        <tr>
                                            <td><input type="checkbox" name="teams[]" value="<?= $team->id ?>"/></td>
                                            <td><?= $team->tag ?></td>
                                            <td><?= $team->name; ?></td>
                                            <td>
                                            <?php if ($team->website !== '') : ?>
                                                <a target="_blank" href="<?= $team->website ?>"><?= $team->website ?></a>
                                            <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                No Teams available to assign!
                            </div>
                        <?php endif; ?>
                        <?= FormBuilder::getInputHidden('clan_id', $clan->id); ?>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm(); ?>
                            <?= FormBuilder::getButtonCancel(URL.'clan/edit/'.$clan->id); ?>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="assigned">
                    <form action="<?= URL ?>/clan/team-remove/<?= $clan->id ?>" method="post">
                        <?php if (count($clanTeams) > 0) : ?>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Tag</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($clanTeams as $clanTeam) : ?>
                                    <?php if ($clanTeam instanceof Team) : ?>
                                        <tr>
                                            <td><input type="checkbox" name="teams[]" value="<?= $clanTeam->id ?>"/></td>
                                            <td><?= $clanTeam->tag ?></td>
                                            <td><?= $clanTeam->name; ?></td>
                                            <td>
                                            <?php if ($clanTeam->website !== '') : ?>
                                                <a target="_blank" href="<?= $clanTeam->website ?>"><?= $clanTeam->website ?></a>
                                            <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                No Teams assigned!
                            </div>
                        <?php endif; ?>
                        <?= FormBuilder::getInputHidden('clan_id', $clan->id); ?>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm(); ?>
                            <?= FormBuilder::getButtonCancel(URL.'clan/edit/'.$clan->id); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
