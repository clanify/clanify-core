<?php
use Clanify\Core\Template\CDN;
use Clanify\Core\Template\MenuBuilder;
use Clanify\Core\CitoEngine;
use Clanify\Core\Template\FormBuilder;
use Clanify\Domain\Entity\User;
use Clanify\Core\Database;
use Clanify\Domain\Entity\Account;

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
$cito->setValue('head', '<script src="'.CDN::getBootstrapJS().'"></script>');
$cito->setValue('head', '<script src="'.$clanifyJS.'"></script>');

//set the body classes.
$cito->setValue('body', 'class="no-bg" id="team-edit"');
$account = $this->getVar('account', new Account());
$user = $this->getVar('user', new User());

if (!($account instanceof Account)) {
    $account = new Account();
}

?>
<div class="container" id="team-edit">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="hide-text-overflow"><?= ($account->id > 0) ? 'Edit Account' : 'Add Account'; ?></h2>
            <form class="ajax" id="table-form" method="post" data-action="<?= URL ?>user/account-save">
                <div class="alert" role="alert"></div>
                <?= FormBuilder::getSelectByTable('account_games', 'account_name', $account->name); ?>
                <?= FormBuilder::getInputText('account_value', '', $account->value); ?>
                <?= FormBuilder::getInputHidden('account_id', $account->id); ?>
                <?= FormBuilder::getInputHidden('user_id', $user->id); ?>
                <div class="pull-right">
                    <?= FormBuilder::getButtonSaveForm(); ?>
                    <?php if ($account->id > 0) : ?>
                        <a class="btn btn-danger btn-sm ajax" data-action="<?= URL ?>user/delete-account/" data-account_id="<?= $account->id ?>" data-user_id="<?= $user->id ?>"><i class="fa fa-trash"></i>Delete</a>
                    <?php endif; ?>
                    <?= FormBuilder::getButtonCancel(URL.'user/edit/'.$user->id.'#tab-accounts'); ?>
                </div>
            </form>
        </div>
    </div>
</div>