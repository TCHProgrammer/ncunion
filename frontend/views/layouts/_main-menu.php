<?php

use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\bootstrap\Nav;

if (Yii::$app->user->isGuest) {
    $menuItemsRight[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
    $menuItemsRight[] = ['label' => 'Войти', 'url' => ['/site/login']];
} else {
    $menuItemsRight[] = [
        'label' => Yii::$app->user->identity->email,
        'items' => [
            ['label' => 'Профиль', 'url' => ['/user/profile']],
            ['label' => 'Каталог', 'url' => ['/catalog'], 'visible' => Yii::$app->user->can('access_menu_catalog')],
            ['label' => 'Настройки', 'url' => ['/user/settings']],
            ['label' => 'Паспорт', 'url' => ['/user/passport'], 'visible' => Yii::$app->user->can('access_menu_passport')            ],
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

$userNavWidget = Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right user-account user-account_navbar-header'],
    'items' => $menuItemsRight
]);

NavBar::begin([
    'brandLabel' => false, 
    'headerContent' => $userNavWidget,
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
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $menuItemsLeft,
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right user-account user-account_right'],
    'items' => $menuItemsRight
]);
NavBar::end();