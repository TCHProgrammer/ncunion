<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\TariffsAsset;
use common\widgets\Alert;
use frontend\widget\AdminPanel;

TariffsAsset::register($this);
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

    <section class="programs" id="programs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h2>Программы доходности</h2>
                        <span class="hidden">Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
            <div class="row programs-wrapper">
                <div class="col-xs-6 col-sm-6">
                    <a href="/tariffs/optimal" class="item-link">
                        <div class="item">
                            <div class="image">
                                <img src="<?php echo Url::to('@web/img/main/program-1.png'); ?>" alt="Доходная" class="img-responsive">
                            </div>
                            <div class="text">
                                <h3>Вклад "Оптимальный"</h3>
                                <div class="row flex-row properties-list">
                                    <div class="col-sm-6">
                                        <div class="property property-price">
                                            <div class="image">
                                                <img src="<?php echo Url::to('@web/img/main/program-icon-price.png'); ?>" alt="Сумма вклада">
                                            </div>
                                            <span class="name">Сумма вклада:</span>
                                            <p>от 50 000 руб</p>
                                            <p>до 1 499 999 руб</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="property property-time">
                                            <div class="image">
                                                <img src="<?php echo Url::to('@web/img/main/program-icon-time.png'); ?>" alt="Срок вклада">
                                            </div>
                                            <span class="name">Срок вклада:</span>
                                            <p>от 3 месяцев</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="property property-percent">
                                            <div class="image">
                                                <img src="<?php echo Url::to('@web/img/main/program-icon-percent.png'); ?>" alt="Выплата процентов">
                                            </div>
                                            <span class="name">Выплата процентов:</span>
                                            <p>в конце срока, ежемесячно</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-6">
                    <div class="item">
                        <div class="image">
                            <img src="<?php echo Url::to('@web/img/main/program-2.png'); ?>" alt="Доходная" class="img-responsive">
                        </div>
                        <div class="text">
                            <h3>Вклад "Универсальный"</h3>
                            <div class="row flex-row properties-list">
                                <div class="col-sm-6">
                                    <div class="property property-price">
                                        <div class="image">
                                            <img src="<?php echo Url::to('@web/img/main/program-icon-price.png'); ?>" alt="Сумма вклада">
                                        </div>
                                        <span class="name">Сумма вклада:</span>
                                        <p>от 1 500 000 руб</p>
                                        <p>до 10 000 000 руб</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="property property-time">
                                        <div class="image">
                                            <img src="<?php echo Url::to('@web/img/main/program-icon-time.png'); ?>" alt="Срок вклада">
                                        </div>
                                        <span class="name">Срок вклада:</span>
                                        <p>от 12 месяцев</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="property property-percent">
                                        <div class="image">
                                            <img src="<?php echo Url::to('@web/img/main/program-icon-percent.png'); ?>" alt="Выплата процентов">
                                        </div>
                                        <span class="name">Выплата процентов:</span>
                                        <p>в конце срока, ежемесячно</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="get-consultation">
        <div class="container">
            <div class="row flex-row">
                <div class="col-sm-12 col-md-8">
                    <div class="heading">
                        <h2>Остались вопросы?</h2>
                        <span>Наши специалисты уже готовы дать профессиональную консультацию!</span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="buttons">
                        <button class="btn btn-default btn-get-consultation btn-consult">Получить консультацию</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-to">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h2>Как стать инвестором</h2>
                        <span>Всё просто! Это делается всего в несколько простых шагов:</span>
                    </div>
                </div>
            </div>
            <div class="row how-to-grid">
                <div class="col-sm-12">
                    <div class="items-wrapper flex">
                        <div class="item">
                            <div class="image">
                                <img src="<?php echo Url::to('@web/img/main/how-to-1.png'); ?>" class="img-responsive">
                            </div>
                            <div class="info">
                                <p>Выплата дохода в конце срока действия договора дополнительные 1,5%</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="<?php echo Url::to('@web/img/main/how-to-2.png'); ?>" alt="" class="img-responsive">
                            </div>
                            <div class="info">
                                <p>Выплата дохода в конце срока действия договора дополнительные 1,5%</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="<?php echo Url::to('@web/img/main/how-to-3.png'); ?>" alt="" class="img-responsive">
                            </div>
                            <div class="info">
                                <p>Выплата дохода в конце срока действия договора дополнительные 1,5%</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="<?php echo Url::to('@web/img/main/how-to-4.png'); ?>" alt="" class="img-responsive">
                            </div>
                            <div class="info">
                                <p>Выплата дохода в конце срока действия договора дополнительные 1,5%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="consultation-form" id="consultation-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="heading">
                        <h2>Заинтересовались?</h2>
                        <span>Выплата дохода в конце срока действия договора дополнительные 1,5%</span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <form action="#">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group"><input type="text" class="form-control" placeholder="Ваше имя"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"><input type="text" class="form-control" placeholder="Email"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"><input type="text" class="form-control" placeholder="Тема сообщения"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"><input type="text" class="form-control" placeholder="Телефон"></div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="" id="" cols="30" rows="10" placeholder="Сообщение"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-buttons">
                                    <input type="submit" class="btn btn-primary" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.3919969563412!2d37.530455816243816!3d55.751692380553074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54bdf26955a8f%3A0x27582effbd2d7a96!2z0KHQtdCy0LXRgNC90LDRjyDQkdCw0YjQvdGP!5e0!3m2!1sru!2sru!4v1539330204523" frameborder="0" style="border:0; width: 100%; height: 550px;"></iframe>
        <div class="contacts-card">
            <div class="text">
                <h2>Офис Москва-Сити</h2>
                <img src="<?php echo Url::to('@web/img/main/contacts-img.jpg'); ?>" alt="Офис Москва-Сити" class="img-responsive">
                <p>г. Москва</p>
                <p>ул. Тестовская, 10, 2 этаж, офис 203/1, ММДЦ “Москва-Сити” БЦ "Северная Башня"</p>
                <p>+ 7 495-294-30-20</p>
                <p>+ 7 495-294-30-20</p>
                <div class="buttons">
                    <button class="btn btn-primary btn-consult">Отправить</button>
                </div>
            </div>
        </div>
    </section>

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
