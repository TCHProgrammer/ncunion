<?php
/**
 * @dmstr\widgets\Menu
 */
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    /*['label' => 'Menu Yii2', 'options' => ['class' => 'header']],*/

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

                    ['label' => 'Объекты', 'icon' => 'fw fa-institution', 'url' => ['/object']],

                    ['label' => 'Тарифф', 'icon' => 'fw fa-line-chart', 'url' => ['/tariff']],

                ],
            ]
        ) ?>

    </section>

</aside>
