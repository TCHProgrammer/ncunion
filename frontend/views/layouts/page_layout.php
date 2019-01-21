<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\widget\AdminPanel;

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
<body class="page user-form-page">
<?php if (!Yii::$app->user->can('ban')){ ?>
<?php $this->beginBody() ?>
<?= AdminPanel::widget(); ?>

    <header>
        <div class="top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="logo">
                            <a href="/">
                                <img src="<?php echo Url::to('@web/img/main/logo.png'); ?>" class="img-responsive">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="header-address">
                            <p>
                                г. Москва, ул. Тестовская, 10, 2 этаж, офис 203/1,ММДЦ<br>“Москва-Сити” БЦ "Северная Башня"
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="header-phone">
                            <p>+ 7 495-294-30-20</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="call-order">
                            <button class="btn btn-primary btn-phone">Обратный звонок</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->render('_main-menu'); ?>
    </header>

    <div class="container">
        <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <footer class="footer animated animated-up">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% </p>
                </div>
                <div class="col-sm-6">
                    <a href="<?= Url::toRoute(['/policy']); ?>">Политика конфиденциальности</a>
                </div>
            </div>
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
