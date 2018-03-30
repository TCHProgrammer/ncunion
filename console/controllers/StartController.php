<?php
namespace console\controllers;
use yii\console\Controller;
use Yii;
use common\models\User;
class StartController extends Controller
{
    public function actionIndex() {

        /**
         * Создаём пользователя
         */
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->save();

        /**
         * Создаём роли
         */
        $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Администратор';
        Yii::$app->authManager->add($admin);

        $user = Yii::$app->authManager->createRole('user');
        $user->description = 'Пользователь';
        Yii::$app->authManager->add($user);

        $unknown = Yii::$app->authManager->createRole('unknown');
        $unknown->description = 'Неизвестный';
        Yii::$app->authManager->add($unknown);

        $ban = Yii::$app->authManager->createRole('ban');
        $ban->description = 'Заблокирован';
        Yii::$app->authManager->add($ban);


        /**
         * Создаём права(доступ)
         */
        $canAdmin = Yii::$app->authManager->createPermission('canAdmin');
        $canAdmin->description = 'Доступ в админку';
        Yii::$app->authManager->add($canAdmin);

        $permission = Yii::$app->authManager->createPermission('widgetAdminPanel');
        $permission->description = 'Виджет админ панели';
        Yii::$app->authManager->add($permission);

        $permission = Yii::$app->authManager->createPermission('admin_menu_rbac_users');
        $permission->description = 'Доступ к меню ролей "Пользователи"';
        Yii::$app->authManager->add($permission);

        $permission = Yii::$app->authManager->createPermission('admin_menu_rbac_permission');
        $permission->description = 'Доступ к меню "Расшифровка доступов"';
        Yii::$app->authManager->add($permission);

        $permission = Yii::$app->authManager->createPermission('admin_menu_rbac_roles');
        $permission->description = 'Доступ к меню "Роли пользователей"';
        Yii::$app->authManager->add($permission);

        /**
         * Наследования ролей и прав
         */
        $role_adm = Yii::$app->authManager->getRole('admin');
        $permit1 = Yii::$app->authManager->getPermission('canAdmin');
        $permit2 = Yii::$app->authManager->getPermission('widgetAdminPanel');
        $permit3 = Yii::$app->authManager->getPermission('admin_menu_rbac_users');
        $permit4 = Yii::$app->authManager->getPermission('admin_menu_rbac_permission');
        $permit5 = Yii::$app->authManager->getPermission('admin_menu_rbac_roles');
        Yii::$app->authManager->addChild($role_adm, $permit1);
        Yii::$app->authManager->addChild($role_adm, $permit2);
        Yii::$app->authManager->addChild($role_adm, $permit3);
        Yii::$app->authManager->addChild($role_adm, $permit4);
        Yii::$app->authManager->addChild($role_adm, $permit5);

        /* меньше строк кода, надо тестить */
        /*$mas = [
            ['widgetAdminPanel', 'Виджет админ панели'],
            ['admin_menu_rbac_users', 'Доступ к меню ролей "Пользователи"'],
            ['admin_menu_rbac_permission', 'Доступ к меню "Расшифровка доступов"'],
            ['admin_menu_rbac_roles', 'Доступ к меню "Роли пользователей"'],
        ];

        $role_adm = Yii::$app->authManager->getRole('admin');
        foreach ($mas as $item){
            $permission = Yii::$app->authManager->createPermission($item[0]);
            $permission->description = $item[1];
            Yii::$app->authManager->add($permission);
            Yii::$app->authManager->addChild($role_adm, $permission);
        }*/

        /**
         * Назначение роли пользователю
         */
        $user_role = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($user_role, 1);
    }
}