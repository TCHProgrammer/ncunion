<?php
namespace console\controllers;
use yii\console\Controller;
use Yii;
use common\models\User;
class CreateRolesController extends Controller
{
    public function actionIndex() {

        /**
         * Создаём пользователя
         */
        /*$user = new User();
        $user->username = 'admin';
        $user->email = 'admin';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->save();*/

        /**
         * Создаём роли
         */
        /*$admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Администратор';
        Yii::$app->authManager->add($admin);

        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = 'Контент менеджер';
        Yii::$app->authManager->add($manager);

        $user = Yii::$app->authManager->createRole('user');
        $user->description = 'Пользователь';
        Yii::$app->authManager->add($user);

        $unknown = Yii::$app->authManager->createRole('unknown');
        $unknown->description = 'Неизвестный';
        Yii::$app->authManager->add($unknown);

        $no_pay = Yii::$app->authManager->createRole('no_pay');
        $no_pay->description = 'Подписка закончилась';
        Yii::$app->authManager->add($no_pay);

        $ban = Yii::$app->authManager->createRole('ban');
        $ban->description = 'Заблокирован';
        Yii::$app->authManager->add($ban);
        */

        /**
         * Создаём права(доступ)
         */
        /*$canAdmin = Yii::$app->authManager->createPermission('canAdmin');
        $canAdmin->description = 'Доступ в админку';
        Yii::$app->authManager->add($canAdmin);*/

        /**
         * Наследования ролей и прав
         */
        /*$role_adm = Yii::$app->authManager->getRole('admin');
        $role_man = Yii::$app->authManager->getRole('manager');
        $permit = Yii::$app->authManager->getPermission('canAdmin');
        Yii::$app->authManager->addChild($role_adm, $permit); //(родительский, дочерний)
        Yii::$app->authManager->addChild($role_man, $permit);*/

        /**
         * Назначение роли пользователю
         */
        /*$user_role = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($user_role, 1);*/
    }
}