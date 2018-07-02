<?php
use \common\models\UserModel;
use yii\helpers\Url;

$user = UserModel::findOne(Yii::$app->user->id);
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $user->email ?></p>
                <a href="<?= Url::to('/') ?>" target="_blank" style="color: #d8d330"><?= 'http://' . $_SERVER['SERVER_NAME'] ?></a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],

                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                    [
                        'label' => 'Нстройки сайта',
                        'icon' => 'fw fa-gears',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Общая информация', 'icon' => 'fw fa-file-o', 'url' => ['/info-site/index'],],
                            ['label' => 'Расшифроква доступов', 'icon' => 'fw fa-eye', 'url' => ['/rbac/permission'],],
                            ['label' => 'Роли пользователей', 'icon' => 'fw  fa-key', 'url' => ['/rbac/roles'],],
                            ['label' => 'Почтовые уведомления', 'icon' => 'fw fa-bullhorn', 'url' => ['/notice/index'],],
                            ['label' => 'Пользователи', 'icon' => 'fw fa-user', 'url' => ['/rbac/users'],],
                            [
                                'label' => 'Some tools',
                                'icon' => 'fw fa-bug',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                                    [
                                        'label' => 'Level One',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                            [
                                                'label' => 'Level Two',
                                                'icon' => 'circle-o',
                                                'url' => '#',
                                                'items' => [
                                                    ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                                    ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],

                    [
                        'label' => 'Пользователи',
                        'icon' => 'fw fa-male',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Ожидаемые модерации', 'icon' => 'fw fa-child', 'url' => ['/users/users-moder'],],
                            ['label' => 'Клиенты', 'icon' => 'fw fa-user', 'url' => ['/users'],],
                        ],
                    ],

                    Yii::$app->user->can('can_create_object') ?
                        ['label' => 'Объекты', 'icon' => 'fw fa-institution', 'url' => ['/object']] : false,

                    Yii::$app->user->can('can_module_tariff') ?
                        ['label' => 'Тарифф', 'icon' => 'fw fa-line-chart', 'url' => ['/tariff']] : false,

                ],
            ]
        ) ?>

    </section>

</aside>
