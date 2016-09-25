<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\Template\FormBuilder;
use Clanify\Core\CitoEngine;
use Clanify\Core\Database;

//get the instance of the CitoEngine.
$cito = CitoEngine::getInstance();

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
$cito->setValue('head', '<link href="'.CDN::getFontAwesomeCSS().'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link href="'.$stylesheet.'" rel="stylesheet" type="text/css">');
$cito->setValue('head', '<link rel="shortcut icon" type="image/x-icon" href="'.$favicon.'"/>');
$cito->setValue('head', '<link href="'.CDN::getBootstrapDatepickerCSS().'" rel="stylesheet" type="text/css">');

//set the footer content.
$cito->setValue('head', '<script src="'.CDN::getJQueryJS().'"></script>');
$cito->setValue('head', '<script src="'.CDN::getBootstrapJS().'"></script>');
$cito->setValue('head', '<script src="'.CDN::getBootstrapDatepickerJS().'"></script>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>');
$cito->setValue('backend_menu', $menuBuilder->getMenu('backend'));
$cito->setValue('backend_menu_user', $menuBuilder->getMenu('backend_user'));
$cito->setValue('username', $_SESSION['user_username']);
$cito->setValue('logo', URL.'src/View/templates/public/img/clanify-logo.png');
$cito->setValue('base_url', URL.'dashboard');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="user-edit"');
$user = $this->getVar('user');
$userAccounts = $this->getVar('accounts', []);
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2><?= ($user->id > 0) ? $user->username : 'Create new User' ?></h2>
            <div class="alert alert-info pill-bar">
                <ul class="nav nav-pills">
                    <li class="active"><a data-target="#info" data-toggle="tab">Info</a></li>
                    <li><a data-target="#tab-accounts" data-toggle="tab">Accounts</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <form class="ajax" method="post" data-action="<?= URL ?>user/save">
                        <div class="alert" role="alert"></div>
                        <?= FormBuilder::getInputText('user_username', 'Username', $user->username) ?>
                        <?= FormBuilder::getInputPassword('user_password', 'Password') ?>
                        <?= FormBuilder::getInputText('user_email', 'E-Mail', $user->email) ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= FormBuilder::getInputText('user_firstname', 'Firstname', $user->firstname) ?>
                            </div>
                            <div class="col-md-6">
                                <?= FormBuilder::getInputText('user_lastname', 'Lastname', $user->lastname) ?>
                            </div>
                        </div>
                        <?= FormBuilder::getInputHidden('user_id', $user->id) ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= FormBuilder::getInputDatepicker('user_birthday', 'Birthday', $user->birthday); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo FormBuilder::getSelectGender('user_gender', $user->gender);
                                ?>
                            </div>
                        </div>
                        <div class="pull-right">
                            <?= FormBuilder::getButtonSaveForm() ?>
                            <?php if ($user->id > 0) : ?>
                                <?= FormBuilder::getButtonDelete(URL.'user/delete/'.$user->id) ?>
                            <?php endif; ?>
                            <?= FormBuilder::getButtonCancel(URL.'user') ?>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab-accounts">
                    <?php if (count($userAccounts) > 0) : ?>
                        <table class="table table-hover accounts table-striped">
                            <tbody>
                            <?php foreach ($userAccounts as $account) : ?>
                                <?php if ($account instanceof \Clanify\Domain\Entity\Account) : ?>
                                    <tr class="<?= strtolower(str_replace('_', '-', $account->name)) ?> ajax" data-account_id="<?= $account->id ?>" data-user_id="<?= $user->id ?>">
                                        <td class="cover"></td>
                                        <td><?= ucwords(strtolower(str_replace('_', ' ', $account->name))) ?><br/>
                                            <span class="value"><?= $account->value ?></span></td>
                                        <td class="action">
                                            <a class="btn btn-md btn-success" href="<?= URL ?>user/edit-account/<?= $user->id ?>/<?= $account->id ?>"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-md btn-danger" data-action="<?= URL ?>user/delete-account"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <a class="btn btn-success btn-sm" href="<?= URL ?>user/create-account/<?= $user->id ?>/0"><i class="fa fa-plus"></i>Add a Account.</a>
                        </div>
                    <?php elseif ($user->id > 0) : ?>
                        <div class="alert alert-warning" role="alert">
                            No Account available!
                            <a href="<?= URL ?>user/create-account/<?= $user->id ?>/0" class="alert-link">Add a Account.</a>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning" role="alert">
                            Please create your User first! You can only assign Accounts to existing Users.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>