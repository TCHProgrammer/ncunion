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
                <div class="row top-wrapper">
                    <div class="col-xs-6 col-sm-3">
                        <div class="logo">
                            <a href="/">
                                <img src="<?php echo Url::to('@web/img/main/logo.png'); ?>" class="img-responsive">
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <div class="header-address">
                            <p>
                                г. Москва, ул. Тестовская, 10, 2 этаж, офис 203/1,ММДЦ<br>“Москва-Сити” БЦ "Северная Башня"
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="header-phone">
                            <p>+ 7 495-294-30-20</p>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2">
                        <div class="call-order">
                            <button class="btn btn-primary btn-phone">Обратный звонок</button>
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
        $menuItemsLeft = [
            ['label' => 'О сервисе', 'url' => ['#about-service']],
            ['label' => 'Программы доходности', 'url' => ['#programs']],
            ['label' => 'Калькуляторы доходности', 'url' => ['#calc']],
            ['label' => 'Гарантии', 'url' => ['#guarantee']],
            ['label' => 'О компании', 'url' => ['#about-service']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItemsRight[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
            $menuItemsRight[] = ['label' => 'Войти', 'url' => ['/site/login']];
        } else {
            //$menuItems[] = ['label' => Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)['user']->name, 'url' => ['/user/profile']];
            // $menuItems[] = ['label' => 'Каталог объектов', 'url' => ['/catalog']];
            // $menuItems[] = ['label' => 'Мои объекты', 'url' => ['/my-object']];
            $menuItemsRight[] = [
                    'label' => Yii::$app->user->identity->email,
                    'items' => [
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
                    ]
                ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => $menuItemsLeft,
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItemsRight
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
            <li style="background-image: url(<?php echo Url::to('@web/img/main/slide-1.jpg'); ?>)">
                <div class="flex-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="slide-row flex">
                                    <div class="item">
                                        <h2><span>Безопасное</span> инвестирование в недвижимость</h2>
                                    </div>
                                    <div class="item item-small">
                                        <p>Всего от<br><span>500 000</span> руб.</p>
                                    </div>
                                    <div class="item item-small">
                                        <p>Доходность:<br><span>10-24 %</span> руб. годовых</p>
                                    </div>
                                </div>
                                <div class="slide-text">
                                    <p>Выберите свою инвестиционную программу! Гарантированный доход, разумное управление рисками, отличная возможность инвестирования как для профессионалов, так и для обычных людей.</p>
                                </div>
                                <div class="slide-button">
                                    <button class="btn btn-default btn-slide">Узнать больше</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li style="background-image: url(<?php echo Url::to('@web/img/main/slide-2.jpg'); ?>)">
                <div class="flex-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="slide-row flex">
                                    <div class="item">
                                        <h2><span>Высокий</span> уровень доходности</h2>
                                    </div>
                                    <div class="item item-small">
                                        <p>Всего от<br><span>500 000</span> руб.</p>
                                    </div>
                                    <div class="item item-small">
                                        <p>Доходность:<br><span>10-24 %</span> руб. годовых</p>
                                    </div>
                                </div>
                                <div class="slide-text">
                                    <p>Отсутствие рисков потери инвестиции, вложения только в высоколиквидные активы, различные инвестиционные программы и опции, позволяющие получать повышенную доходность! Стать инвестором и зарабатывать может каждый!</p>
                                </div>
                                <div class="slide-button">
                                    <button class="btn btn-default btn-slide">Узнать больше</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </section>

    <section class="advantages">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 item-wrapper">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 image-wrapper">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo Url::to('@web/img/main/shield.png'); ?>" alt="Безопасно">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div class="info">
                                    <h3>Безопасно</h3>
                                    <p>Инвестиции не только вернутся, но и принесут неплохой доход. Гарантируем!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 item-wrapper">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 image-wrapper">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo Url::to('@web/img/main/thumb-up.png'); ?>" alt="Выгодно">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div class="info">
                                    <h3>Выгодно</h3>
                                    <p>Процент доходности больше, чем в банках! Зачем зарабатывать мало, если с нами можно заработать много?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 item-wrapper">
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 image-wrapper">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo Url::to('@web/img/main/pocket.png'); ?>" alt="Доступно каждому">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div class="info">
                                    <h3>Доступно каждому</h3>
                                    <p>Начальная сумма инвестиций от 500 000 рублей! Бесплатные консультации начинающим инвесторам.</p>
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
                        <span class="hidden">Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
            <div class="row programs-wrapper">
                <div class="col-xs-6 col-sm-6">
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
                <div class="col-xs-6 col-sm-6">
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
                <div class="col-xs-6 col-sm-6">
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
                <div class="col-xs-6 col-sm-6">
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
                <div class="col-sm-12 col-md-8">
                    <div class="heading">
                        <h2>Есть вопросы? Пишите!</h2>
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

    <section class="calculator" id="calculator">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h2>Калькулятор вашего дохода</h2>
                        <span>моментально узнайте будущую выгоду!</span>
                    </div>
                </div>
            </div>
            <div class="row calculator-row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="input-calc">Сумма инвестиций</label>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-6">
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
            <div class="row items-row">
                <div class="col-xs-6 col-lg-3 item-wrapper">
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
                            <button class="btn btn-default message-button btn-consult">Оставить заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-lg-3 item-wrapper">
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
                            <button class="btn btn-default message-button btn-consult">Оставить заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-lg-3 item-wrapper">
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
                            <button class="btn btn-default message-button btn-consult">Оставить заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-lg-3 item-wrapper">
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
                            <button class="btn btn-default message-button btn-consult">Оставить заявку</button>
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
                        <span class="hidden">Сайт рыбатекст поможет дизайнеру</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="why-we-carousel owl-carousel">
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-1.jpg'); ?>" alt="Высокая безопасность вкладов" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокая безопасность вкладов</h3>
                    <p>Мы работаем только с высоколиквидными объектами недвижимости, гарантированно приносящими стабильный доход</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-2.jpg'); ?>" alt="Гарантированный доход" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Гарантированный доход</h3>
                    <p>Вы при любых обстоятельствах и колебаниях рынка сможете получить тот доход, на который рассчитываете</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-3.jpg'); ?>" alt="Высокие проценты" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокие проценты</h3>
                    <p>Доходность выше, чем по банковским вкладам, её уровень зависит от выбора программы инвестирования и дополнительных опций</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-4.jpg'); ?>" alt="Различные программы инвестирования" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Различные программы инвестирования</h3>
                    <p>Выбирайте то, что подходит именно Вам! Ориентируйтесь на процент доходности, срок инвестирования и стартовый уровень вложений</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-5.jpg'); ?>" alt="Возможности для получения увеличенных процентов доходности" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Возможности для получения увеличенных процентов доходности</h3>
                    <p>Воспользуйтесь предлагаемыми опциями инвест.программ и просто получайте дополнительный доход</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-6.jpg'); ?>" alt="Различные сроки размещения вложений" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Различные сроки размещения вложений</h3>
                    <p>Сроки инвестирования от хх месяцев до хх лет. Один из параметров, влияющих на процент доходности вклада.</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-7.jpg'); ?>" alt="Высокий профессионализм команды" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Высокий профессионализм команды</h3>
                    <p>В нашей компании работают исключительно высококлассные специалисты с опытом работы в крупнейших мировых финансовых организациях</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-8.jpg'); ?>" alt="Работа с надежными активами высокой ликвидности" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Работа с надежными активами высокой ликвидности</h3>
                    <p>Мы работаем только с теми объектами недвижимости, которые действительно имеют ценность и приносят стабильный доход</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-9.jpg'); ?>" alt="17 лет на финансовом рынке" class="img-responsive">
                </div>
                <div class="info">
                    <h3>17 лет на финансовом рынке</h3>
                    <p>Компания «Национальный кредитный союз» успешно ведет деятельность на финансовом рынке с 2001 года</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-10.jpg'); ?>" alt="Офис в Москва-Сити" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Офис в Москва-Сити</h3>
                    <p>Мы находимся в самом сердце деловой жизни столицы, в Северной Башне ММДЦ Москва-Сити</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-11.jpg'); ?>" alt="Персональный менеджер для каждого клиента" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Персональный менеджер для каждого клиента</h3>
                    <p>Вы точно знаете, к кому можно обратиться по любому возникающему вопросу</p>
                </div>
            </div>
            <div class="item">
                <div class="image">
                    <img src="<?php echo Url::to('@web/img/main/item-12.jpg'); ?>" alt="Полная прозрачность и отчет по всем операциям" class="img-responsive">
                </div>
                <div class="info">
                    <h3>Полная прозрачность и отчет по всем операциям</h3>
                    <p>Вы регулярно будете получать отчетность о состоянии вклада и процентов доходности удобным для Вас способом</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="order-button">
                        <button class="btn btn-primary btn-order btn-consult">Звоните <br><span>+ 7 495-294-30-20</span></button>
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
                            <span class="subheading hidden">Сайт рыбатекст поможет дизайнеру</span>
                            <h3>Почему нам уже доверилось более 2 500 инвесторов?</h3>
                            <p>На самом деле, все просто:</p>
                            <ul>
                                <li>У нас высокие проценты доходности</li>
                                <li>Гарантированные выплаты</li>
                                <li>Различные инвестиционные программы</li>
                                <li>Персональный подход к каждому клиенту</li>
                                <li>Превосходная репутация на рынке</li>
                            </ul>
                            <a href="#" class="btn btn-default">Подробнее</a>
                        </div>
                        <div class="item item-blue">
                            <h3>Мы эксперты в:</h3>
                            <p>инвестировании в недвижимость</p>
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
                        <span>Всё просто! Это делается всего в несколько простых шагов:</span>
                    </div>
                </div>
            </div>
            <div class="row how-to-grid">
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

    <section class="consultation-form" id="consultation-form">
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
