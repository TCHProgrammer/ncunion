<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\User;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use frontend\assets\ProfileAsset;
use common\widgets\Alert;
use frontend\widget\AdminPanel;

ProfileAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="theme-orange">
<?php if (!Yii::$app->user->can('ban')){ ?>
<?php $this->beginBody() ?>
<?= AdminPanel::widget(); ?>
<!-- Page Loader -->
<div class="page-loader-wrapper" style="display: none;">
    <!-- <div class="loader">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <p>Please wait...</p>
        <div class="m-t-30"><img src="assets/images/logo.svg" width="48" height="48" alt="Nexa"></div>
    </div> -->
</div>
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<nav class="navbar">
    <div class="col-12">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/"><?= Yii::$app->name ?></a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="javascript:void(0);" class="fullscreen hidden-sm-down" data-provide="fullscreen" data-close="true">
                    <i class="zmdi zmdi-fullscreen"></i>
                </a>
            </li>

        </ul>
    </div>
</nav>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="<?= (isset($userAvatar->avatar)) ? $userAvatar->avatar : Url::to('@web/img/other/default-avatar.png') ?>" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown"><?= Yii::$app->user->identity->first_name ?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="button"> keyboard_arrow_down </i>
                <?php
                echo Menu::widget([
                    'items' => [
                        // Important: you need to specify url as 'controller/action',
                        // not just as 'controller' even if default action is used.
                        [
                            'label' => '<i class="material-icons">person</i>Профиль',
                            'url' => ['/user/profile'],
                        ],
                        ['options'=> ['class'=>'divider'],],
                        ['label' => '<i class="material-icons">settings</i>Настройки', 'url' => ['/user/settings']],
                        ['label' => 'Паспорт', 'url' => ['/user/passport']],
                        [
                            'label'    => 'Выйти',
                            'url'      => ['/site/logout'],
                            'template' => '<a href="{url}" data-method="post" data-confirm="Вы уверены ?">{label}</a>'
                        ]

                    ],
                    'options'=>[
                        'class' => 'dropdown-menu slideUp'
                    ],
                    'encodeLabels' => false,
                    'activateItems' => false,
                ]);
                ?>
            </div>
            <div class="email"><?= Yii::$app->user->identity->email ?></div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">ОСНОВНАЯ НАВИГАЦИЯ</li>
            <li class="active open">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
                <?php
                echo Menu::widget([
                    'items' => [
                        // Important: you need to specify url as 'controller/action',
                        // not just as 'controller' even if default action is used.
                        ['label' => 'Главная', 'url' => ['/site/index']],
                        ['label' => 'Профиль', 'url' => ['/user/profile']],
                        ['label' => 'Настройки', 'url' => ['/user/settings']],
                        ['label' => 'Паспорт', 'url' => ['/user/passport']],
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ],
                    'options'=>[
                        'class' => 'ml-menu'
                    ],
                ]);
                ?>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
</aside>

<?= $content ?>

    <!-- <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => '/',
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        //$menuItems[] = ['label' => Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)['user']->name, 'url' => ['/user/profile']];
        $menuItems[] = ['label' => 'Каталог объектов', 'url' => ['/catalog']];
        $menuItems[] = ['label' => 'Мои объекты', 'url' => ['/my-object']];
        $menuItems[] = ['label' => Yii::$app->user->identity->email, 'items' => [
            ['label' => 'Профиль', 'url' => ['/user/profile']],
            ['label' => 'Настройки', 'url' => ['/user/settings']],
            ['label' => 'Паспорт', 'url' => ['/user/passport']],
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти',
                ['class' => 'menu-exit']
            )
            . Html::endForm()
            . '</li>'
        ]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?> -->


    <!-- <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
        <?= Alert::widget() ?> -->

<footer class="footer">
    <div class="container">
        <p class="pull-left"></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php }else{ ?>

<div class="ban-fon">
    <div class="ban-contend">
        <div class="ban-text">
            <h2>Вы были забанены, свяжитесь с администратором!</h2>
            <form action="/site/logout" method="post">
                <input type="hidden" name="_csrf-frontend" value="IAuTD3kiZhigDYINZiLbpA8LMvYiqD-SZYwMjO3wVtAWVN1CC0lLXcJD1UQeWLzeZHhquG_GWsYftD-ho5oV5Q==">
                <div class="no-access-exit">
                    <span class="glyphicon glyphicon-log-out"></span>
                    <button type="submit" class="btn btn-link logout">выход</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php } ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
