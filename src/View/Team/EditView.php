<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\CitoEngine;
use Clanify\Domain\Entity\User;
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
$cito->setValue('footer', '<script src="'.CDN::getBootstrapJS().'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="team-edit"');
$team = $this->getVar('team');
$teamMember = $this->getVar('team_member', []);
?>
<div class="container" id="team-edit">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="hide-text-overflow"><?= $team->id > 0 ? $team->name : 'Create Team' ?></h2>
            <div class="alert alert-info pill-bar">
                <ul class="nav nav-pills">
                    <li class="active"><a data-target="#info" data-toggle="tab">Info</a></li>
                    <li><a data-target="#member" data-toggle="tab">Member</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <form class="ajax" method="post" data-action="<?= URL ?>team/save">
                        <div class="alert" role="alert"></div>
                        <?= FormBuilder::getInputText('team_name', 'Name', $team->name); ?>
                        <?= FormBuilder::getInputText('team_tag', 'Tag', $team->tag); ?>
                        <?= FormBuilder::getInputText('team_website', 'Website', $team->website); ?>
                        <?= FormBuilder::getInputHidden('team_id', $team->id); ?>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm(); ?>
                            <?php if ($team->id > 0) : ?>
                                <?= FormBuilder::getButtonDelete(URL.'team/delete/'.$team->id); ?>
                            <?php endif; ?>
                            <?= FormBuilder::getButtonCancel(URL.'team'); ?>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="member">
                    <?php if (count($teamMember) > 0) : ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($teamMember as $member) : ?>
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
                            <?= FormBuilder::getButtonOrganize(URL.'team/organize-member/'.$team->id, 'Organize Member'); ?>
                        </div>
                    <?php elseif ($team->id > 0) : ?>
                        <div class="alert alert-warning" role="alert">
                            No Member available!
                            <a href="<?= URL ?>team/organize-member/<?= $team->id ?>" class="alert-link">Add a Member.</a>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning" role="alert">
                            Please create your Team first! You can only assign Members to existing Teams.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>