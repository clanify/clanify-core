<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\CitoEngine;
use Clanify\Core\Template\FormBuilder;
use Clanify\Domain\Entity\User;
use Clanify\Domain\Entity\Clan;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();
$logo = URL.'src/View/templates/public/img/clanify-logo.png';
$stylesheet = URL.'src/View/templates/public/css/style.css';
$favicon = URL.'src/View/templates/public/img/favicon.ico';
$clanifyJS = URL.'src/View/templates/public/js/clanify.js';
$menuBuilder = new MenuBuilder(\Clanify\Core\Database::getInstance()->getConnection());

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
$users = $this->getVar('users', []);
$members = $this->getVar('members', []);
?>
<div class="container" id="clan-edit">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="hide-text-overflow">Organize Member</h2>
            <div class="alert alert-info pill-bar">
                <ul class="nav nav-pills">
                    <li class="active"><a data-target="#not-assigned" data-toggle="tab">Not Assigned</a></li>
                    <li><a data-target="#assigned" data-toggle="tab">Assigned</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="not-assigned">
                    <form action="<?= URL ?>/clan/member-add/<?= $clan->id ?>" method="post">
                        <?php if (count($users) > 0) : ?>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <?php if ($user instanceof User) : ?>
                                        <?php if (in_array($user, $members) === false) : ?>
                                            <tr>
                                                <td>
                                                    <label class="sr-only" for="members-add">Add User</label>
                                                    <input type="checkbox" id="members-add" name="members[]" value="<?= $user->id ?>"/>
                                                </td>
                                                <td><?= $user->username ?></td>
                                                <td><?= $user->getFullname(); ?></td>
                                                <td>
                                                <?php if ($user->email !== '') : ?>
                                                    <a target="_blank" href="mailto:<?= $user->email ?>"><?= $user->email ?></a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                No Users available to assign!
                            </div>
                        <?php endif; ?>
                        <?= FormBuilder::getInputHidden('clan_id', $clan->id); ?>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm('Add User'); ?>
                            <?= FormBuilder::getButtonCancel(URL.'clan/edit/'.$clan->id); ?>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="assigned">
                    <form action="<?= URL ?>/clan/member-remove/<?= $clan->id ?>" method="post">
                        <?php if (count($members) > 0) : ?>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($members as $member) : ?>
                                    <?php if ($member instanceof User) : ?>
                                        <tr>
                                            <td>
                                                <label class="sr-only" for="members-remove">Remove Member</label>
                                                <input type="checkbox" id="members-remove" name="members[]" value="<?= $member->id ?>"/>
                                            </td>
                                            <td><?= $member->username ?></td>
                                            <td><?= $member->getFullname(); ?></td>
                                            <td>
                                            <?php if ($member->email !== '') : ?>
                                                <a target="_blank" href="mailto:<?= $member->email ?>"><?= $member->email ?></a>
                                            <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                No Members available!
                            </div>
                        <?php endif; ?>
                        <?= FormBuilder::getInputHidden('clan_id', $clan->id); ?>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm('Remove Member'); ?>
                            <?= FormBuilder::getButtonCancel(URL.'clan/edit/'.$clan->id); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
