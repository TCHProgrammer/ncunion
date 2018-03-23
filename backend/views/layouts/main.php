<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\components\menu\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php if(Yii::$app->user->can('canAdmin')){ ?>
<?php $userPermissions = Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id) ?>
<div class="wrap">
    <?php if (!(Yii::$app->user->isGuest)) { ?>
        <?php /*NavBar::begin([
            'brandLabel' => 'Админка',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();*/?>

        <div class="sidebar-left">
            <div class="sidebar-left-title">
                <h4>Панель управления</h4>
            </div>
            <div class="sidebar-left-link">
                <a href="http://<?= \yii\helpers\Url::home() ?>" target="_blank">http://<?= $_SERVER['HTTP_HOST'] ?></a>
            </div>

            <hr>

            <div class="menu">
                <ul class="nav navmenu-nav">
                    <!--<li class="active"><a href="#">Пункт 1</a></li>-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Настройки сайта<b class="caret"></b></a>
                        <ul class="dropdown-menu navmenu-nav small-menu">
                            <?php
                            foreach ($userPermissions as $permission => $item){
                                $object = new Menu();
                                $menu = $object->link($permission);
                                if ($menu) {
                                    echo '<li><a href="' . $menu['link'] . '">' . $menu['title'] . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <!-- Супер  мега идея!! сделать меню, что бы оно само генерировалось исходя от роли или тупо создать ... -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Контент<b class="caret"></b></a>
                        <ul class="dropdown-menu navmenu-nav small-menu">
                            <li><a href="/admin/roles">Новости</a></li
                        </ul>
                    </li>


                    <li><a href="#">тест</a></li>
                    <li><a href="#">Пункт 3</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Доступы<b class="caret"></b></a>
                        <ul class="dropdown-menu navmenu-nav small-menu">
                            <li><a href="/admin/roles">Роли и доступы</a></li>
                            <li><a href="/admin/roles/auth-item">auth-item</a></li>
                            <li><a href="/admin/roles/auth-assignment">auth-assignment</a></li>
                            <li><a href="/admin/roles/auth-item-child">auth-item-child</a></li>
                            <li><a href="/admin/roles/auth-rule">auth-rule</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">rbac<b class="caret"></b></a>
                        <ul class="dropdown-menu navmenu-nav small-menu">
                            <li><a href="/admin/rbac1">index</a></li>
                            <li><a href="/admin/rbac1/route">route</a></li>
                            <li><a href="/admin/rbac1/permission">Разрешения</a></li>
                            <li><a href="/admin/rbac1/role">Роли</a></li>
                            <li><a href="/admin/rbac1/assignment">assignment</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>

    <div class="content">

        <div class="sidebar-top">
            <div class="sidebar-top">
                <i class="fa fa-sign-out"></i>
                <form action="/admin/site/logout" method="post">
                    <input type="hidden" name="_csrf-backend" value="0z-xn-Sot0FPPnbYKrBixJlsFShTrswpSQ8sJxKi8P_haP_qgM7YLCcKH6hn0Qj0wFlQUWXIoWsOSxRSUM64iA==">
                    <button type="submit" class="btn btn-link logout">Выход (admin)</button>
                </form>
            </div>
        </div>

        <div class="my-container">
    <?php }else{ ?>
        <div class="content-login">
            <div class="my-container">
    <?php } ?>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php }else{ ?>
    <div class="no-access-fon">
        <div class="no-access-text">
            <div class="no-access-content">
                <h2>Доступ запрещен!</h2>
                <p>У Вас нет прав для доступа к этому разделу.</p>
                <form action="/admin/site/logout" method="post">
                    <input type="hidden" name="_csrf-backend" value="0z-xn-Sot0FPPnbYKrBixJlsFShTrswpSQ8sJxKi8P_haP_qgM7YLCcKH6hn0Qj0wFlQUWXIoWsOSxRSUM64iA==">
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
