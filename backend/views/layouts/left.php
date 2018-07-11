<?php
use \common\models\UserModel;
use yii\helpers\Url;
use backend\components\menu\Menu;

$user = UserModel::findOne(Yii::$app->user->id);

$menu = new Menu();
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/adminPanel/yii2-cdn.png" class="img-circle" alt="User Image"/>
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
                        'visible' => $menu->menuSettingsSite(),
                        'items' => [
                            [
                                'label' => 'Общая информация',
                                'icon' => 'fw fa-file-o',
                                'url' => ['/info-site/index'],
                                'visible' => Yii::$app->user->can('info_site')
                            ],
                            [
                                'label' => 'Расшифроква доступов',
                                'icon' => 'fw fa-eye',
                                'url' => ['/rbac/permission'],
                                'visible' => Yii::$app->user->can('admin_menu_rbac_permission')
                            ],
                            [
                                'label' => 'Роли пользователей',
                                'icon' => 'fw  fa-key',
                                'url' => ['/rbac/roles'],
                                'visible' => Yii::$app->user->can('admin_menu_rbac_roles')
                            ],
                            [
                                'label' => 'Почтовые уведомления',
                                'icon' => 'fw fa-bullhorn',
                                'url' => ['/notice/index'],
                                'visible' => Yii::$app->user->can('settings_add_email_push')
                            ],
                            [
                                'label' => 'Пользователи',
                                'icon' => 'fw fa-user',
                                'url' => ['/rbac/users'],
                                'visible' => Yii::$app->user->can('admin_menu_rbac_users')
                            ],
                            [
                                'label' => 'Some tools',
                                'icon' => 'fw fa-bug',
                                'url' => '#',
                                'visible' => Yii::$app->user->can('can_some_tools'),
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
                        'visible' => $menu->menuUsers(),
                        'items' => [
                            [
                                'label' => 'Ожидаемые модерации',
                                'icon' => 'fw fa-child',
                                'url' => ['/users/users-moder'],
                                'visible' => Yii::$app->user->can('users_moder')
                            ],
                            [
                                'label' => 'Клиенты',
                                'icon' => 'fw fa-user',
                                'url' => ['/users'],
                                'visible' => Yii::$app->user->can('users_clients')
                            ],
                        ],
                    ],

                    [
                        'label' => 'Объекты',
                        'icon' => 'fw fa-institution',
                        'url' => ['/object'],
                        'visible' => $menu->menuObject()
                    ],

                    [
                        'label' => 'Тарифф',
                        'icon' => 'fw fa-line-chart',
                        'url' => ['/tariff'],
                        'visible' => $menu->menuTariff()
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
