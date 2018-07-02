<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">ADM</span><span class="logo-lg">Панель управления</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top navbar-adm-top" role="navigation">

        <a href="#" class="sidebar-toggle sidebar-toggle-adm" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <?= Html::a(
                        'Выйти',
                        ['/site/logout'],
                        ['data-method' => 'post', 'class' => 'btn-logout']
                    ) ?>
                </li>

                <!--<div>
                    <form class="sidebar-top-exit1" action="<?//= Url::toRoute('site/logout') ?>" method="post">
                        <input type="hidden" name="_csrf-backend" value="0z-xn-Sot0FPPnbYKrBixJlsFShTrswpSQ8sJxKi8P_haP_qgM7YLCcKH6hn0Qj0wFlQUWXIoWsOSxRSUM64iA==">
                        <span class="glyphicon1 glyphicon-log-out1" style="top:2px"></span>
                        <button type="submit" class="btn1 btn-link1 logou1t">Выход (admin)</button>
                    </form>
                </div>-->

                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>
