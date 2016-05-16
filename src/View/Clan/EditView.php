<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\CitoEngine;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Entity\Team;
use Clanify\Core\Template\FormBuilder;
use Clanify\Core\Database;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();
$logo = URL.'src/View/templates/public/img/clanify-logo.png';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$favicon = URL.'src/View/templates/public/img/favicon.ico';
$menuBuilder = new MenuBuilder(Database::getInstance()->getConnection());
$clanifyJS = URL.'src/View/templates/public/js/clanify.js';

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
$cito->setValue('head', '<link href="'.CDN::getFontAwesomeCSS().'" rel="stylesheet" type="text/css">');
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
$cito->setValue('head', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>');
$cito->setValue('footer', '<script src="'.CDN::getBootstrapJS().'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="clan-edit"');
$clan = $this->getVar('clan');
$clanMember = $this->getVar('clan_member', []);
$clanTeams = $this->getVar('clan_teams', []);
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="hide-text-overflow"><?= $clan->id > 0 ? $clan->name : 'New Clan / Community'; ?></h2>
            <div class="alert alert-info pill-bar">
                <ul class="nav nav-pills">
                    <li class="active"><a data-target="#info" data-toggle="tab">Info</a></li>
                    <li><a data-target="#member" data-toggle="tab">Member</a></li>
                    <li><a data-target="#teams" data-toggle="tab">Teams</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <form class="ajax" method="post" id="clan" data-action="<?= URL ?>clan/save">
                        <div class="alert" role="alert"></div>
                        <?= FormBuilder::getInputText('clan_name', 'Name', $clan->name); ?>
                        <?= FormBuilder::getInputText('clan_tag', 'Tag', $clan->tag); ?>
                        <?= FormBuilder::getInputText('clan_website', 'Website', $clan->website); ?>
                        <?= FormBuilder::getInputHidden('clan_id', $clan->id); ?>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm(); ?>
                            <?php if ($clan->id > 0) : ?>
                                <?= FormBuilder::getButtonDelete(URL.'clan/delete/'.$clan->id); ?>
                            <?php endif; ?>
                            <?= FormBuilder::getButtonCancel(URL.'clan'); ?>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="member">
                    <?php if (count($clanMember) > 0) : ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($clanMember as $member) : ?>
                                <?php if ($member instanceof User) : ?>
                                    <tr>
                                        <td><?= $member->username ?></td>
                                        <td><?= $member->getFullname() ?></td>
                                        <td onclick="preventOnClick()">
                                        <?php if ($member->email !== '') : ?>
                                            <a target="_blank" href="mailto:<?= $member->email ?>"><?= $member->email ?></a>
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonOrganize(URL.'clan/member-organize/'.$clan->id, 'Organize Member'); ?>
                        </div>
                    <?php elseif ($clan->id > 0) : ?>
                        <div class="alert alert-warning" role="alert">
                            No Member available!
                            <a href="<?= URL ?>clan/member-organize/<?= $clan->id ?>" class="alert-link">Add a Member.</a>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning" role="alert">
                            Please create your Clan first! You can only assign Users to existing Clans.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane" id="teams">
                    <?php if (count($clanTeams) > 0) : ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Tag</th>
                                <th>Website</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($clanTeams as $team) : ?>
                                <?php if ($team instanceof Team) : ?>
                                    <tr>
                                        <td><?= $team->name ?></td>
                                        <td><?= $team->tag ?></td>
                                        <td><?= ($team->website !== '') ? '<a target="_blank" href="'.$team->website.'">'.$team->website.'</a>' : '' ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonOrganize(URL.'clan/team-organize/'.$clan->id, 'Organize Teams'); ?>
                        </div>
                    <?php elseif ($clan->id > 0) : ?>
                        <div class="alert alert-warning" role="alert">
                            No Teams available!
                            <a href="<?= URL ?>clan/team-organize/<?= $clan->id ?>" class="alert-link">Add a Team.</a>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning" role="alert">
                            Please create your Clan first! You can only assign Teams to existing Clans.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>