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
<body>
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
                            <button class="btn btn-phone">Обратный звонок</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        NavBar::begin([
            'brandLabel' => false,
            'options' => [
                'class' => 'navbar-default',
            ],
        ]);
        $menuItems = [
            ['label' => 'О сервисе', 'url' => ['#about-service']],
            ['label' => 'Программы доходности', 'url' => ['#programs']],
            ['label' => 'Калькуляторы доходности', 'url' => ['#calc']],
            ['label' => 'Гарантии', 'url' => ['#guarantee']],
            ['label' => 'О компании', 'url' => ['#about-service']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
        } else {
            //$menuItems[] = ['label' => Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)['user']->name, 'url' => ['/user/profile']];
            // $menuItems[] = ['label' => 'Каталог объектов', 'url' => ['/catalog']];
            // $menuItems[] = ['label' => 'Мои объекты', 'url' => ['/my-object']];
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
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
        <!--
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        -->
    </header>

    <section class="slider flexslider">
        <ul class="slides">
            <li>
                <img src="<?php echo Url::to('@web/img/main/slide-1.jpg'); ?>" alt="Слайд 1">
                <div class="flex-caption"></div>
            </li>
            <li>
                <img src="<?php echo Url::to('@web/img/main/slide-2.jpg'); ?>" alt="Слайд 2">
                <div class="flex-caption"></div>
            </li>
        </ul>
    </section>

    <section class="advantages">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo Url::to('@web/img/main/shield.png'); ?>" alt="Безопасно">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="info">
                                    <h3>Безопасно</h3>
                                    <p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo Url::to('@web/img/main/thumb-up.png'); ?>" alt="Выгодно">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="info">
                                    <h3>Выгодно</h3>
                                    <p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo Url::to('@web/img/main/pocket.png'); ?>" alt="Доступно каждому">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="info">
                                    <h3>Доступно каждому</h3>
                                    <p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="programs" id="programs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h2>Программы доходности</h2>
                        <span>Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="item">
                        <div class="image">
                            <img src="<?php echo Url::to('@web/img/main/program-1.png'); ?>" alt="Доходная" class="img-responsive">
                        </div>
                        <div class="text">
                            <h3>Доходная</h3>
                            <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="item small-padding">
                        <div class="image">
                            <img src="<?php echo Url::to('@web/img/main/program-2.png'); ?>" alt="Доходная" class="img-responsive">
                        </div>
                        <div class="text">
                            <h3>Доходная</h3>
                            <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="item">
                        <div class="image">
                            <img src="<?php echo Url::to('@web/img/main/program-3.png'); ?>" alt="Доходная" class="img-responsive">
                        </div>
                        <div class="text">
                            <h3>Доходная</h3>
                            <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="item">
                        <div class="image">
                            <img src="<?php echo Url::to('@web/img/main/program-4.png'); ?>" alt="Доходная" class="img-responsive">
                        </div>
                        <div class="text">
                            <h3>Доходная</h3>
                            <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="get-consultation">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="heading">
                        <h2>Остались вопросы?</h2>
                        <span>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="buttons">
                        <button class="btn btn-default">Получить консультацию</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="calculator" id="calculator">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h2>Калькулятор вашего дохода</h2>
                        <span>Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
            <div class="row calculator-row">
                <div class="col-sm-3">
                    <label for="input-calc">Сумма инвестиций</label>
                </div>
                <div class="col-sm-6">
                    <input id="input-calc"
                           data-slider-id='input-calc-slider'
                           type="text"
                           type="text"
                           data-min="100000"
                           data-max="10000000"
                           data-step="50000"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="item item-1">
                        <div class="info">
                            <span class="price-name">Доход</span>
                            <p class="price" data-percent="0.1"><span>35000</span> P</p>
                            <h3>Программа <span>Доходная</span></h3>
                            <p class="text">Выплата в конце срока, ежемесячно или ежеквартально Дополнительные 3
                                процента годовых при получении дохода в конце срока договора</p>
                            <ul class="options">
                                <li>Сумма вложений 1 750 000 Р</li>
                                <li>Чистый доход 304 500 Р</li>
                                <li>НДФЛ 45 500 Р</li>
                            </ul>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-default message-button">Оставить заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="item item-2">
                        <div class="info">
                            <span class="price-name">Доход</span>
                            <p class="price" data-percent="0.15"><span>140000</span> P</p>
                            <h3>Программа <span>Доходная</span></h3>
                            <p class="text">Выплата в конце срока, ежемесячно или ежеквартально Дополнительные 3
                                процента годовых при получении дохода в конце срока договора</p>
                            <ul class="options">
                                <li>Сумма вложений 1 750 000 Р</li>
                                <li>Чистый доход 304 500 Р</li>
                                <li>НДФЛ 45 500 Р</li>
                            </ul>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-default message-button">Оставить заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="item item-3">
                        <div class="info">
                            <span class="price-name">Доход</span>
                            <p class="price" data-percent="0.2"><span>392000</span> P</p>
                            <h3>Программа <span>Доходная</span></h3>
                            <p class="text">Выплата в конце срока, ежемесячно или ежеквартально Дополнительные 3
                                процента годовых при получении дохода в конце срока договора</p>
                            <ul class="options">
                                <li>Сумма вложений 1 750 000 Р</li>
                                <li>Чистый доход 304 500 Р</li>
                                <li>НДФЛ 45 500 Р</li>
                            </ul>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-default message-button">Оставить заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="item item-4">
                        <div class="info">
                            <span class="price-name">Доход</span>
                            <p class="price" data-percent="0.24"><span>798000</span> P</p>
                            <h3>Программа <span>Доходная</span></h3>
                            <p class="text">Выплата в конце срока, ежемесячно или ежеквартально Дополнительные 3
                                процента годовых при получении дохода в конце срока договора</p>
                            <ul class="options">
                                <li>Сумма вложений 1 750 000 Р</li>
                                <li>Чистый доход 304 500 Р</li>
                                <li>НДФЛ 45 500 Р</li>
                            </ul>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-default message-button">Оставить заявку</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="why-we">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h2>Почему мы?</h2>
                        <span>Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="why-we-carousel owl-carousel">
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-1.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-2.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-3.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-4.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-1.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-2.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-3.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-4.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-1.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-2.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-3.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-4.jpg'); ?>" alt="Высокая безопасность" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность</h3>
                    <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="order-button">
                        <button class="btn btn-order">Звоните <br><span>+ 7 495-294-30-20</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="grid">
                        <div class="item item-image"><img src="<?php echo Url::to('@web/img/main/why-1.jpg'); ?>" class="img-responsive"></div>
                        <div class="item">
                            <span class="subheading">Сайт рыбатекст поможет дизайнеру</span>
                            <h3>Почему нам уже доверились более 2500 инвесторов</h3>
                            <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения. Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения. Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры, при предъявлении пенсионного удостоверения.</p>
                            <a href="#" class="btn btn-default">Подробнее</a>
                        </div>
                        <div class="item item-blue">
                            <h3>Мы эксперты в этих направлениях</h3>
                            <p>Выплата дохода в конце срока действия договора дополнительные 1,5% годовых, на новые договоры,</p>
                            <ul>
                                <li>Выплата дохода в конце срока действия договора</li>
                                <li>Выплата дохода в конце срока действия договора</li>
                                <li>Выплата дохода в конце срока действия договора</li>
                                <li>Выплата дохода в конце срока действия договора</li>
                            </ul>
                            <a href="#" class="btn btn-default">Подробнее</a>
                        </div>
                        <div class="item item-image"><img src="<?php echo Url::to('@web/img/main/why-2.jpg'); ?>" class="img-responsive"></div>
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
                        <span>Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 flex">
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
    </section>

    <section class="consultation-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="heading">
                        <h2>Заинтересовались?</h2>
                        <span>Выплата дохода в конце срока действия договора дополнительные 1,5%</span>
                    </div>
                </div>
                <div class="col-sm-7">
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
                                    <textarea name="" id="" cols="30" rows="10"></textarea>
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
        <img src="" alt="" class="img-responsive">
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="pull-left">Выплата дохода в конце срока действия договора дополнительные 1,5% </p>
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
