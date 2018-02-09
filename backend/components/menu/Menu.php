<?php
namespace backend\components\menu;
use Yii;
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 23.03.2018
 * Time: 16:20
 */

class Menu {

    /* Настройки сайта */
    function menuSettingsSite(){
        $permissions = [
            'admin_menu_rbac_roles',
            'admin_menu_rbac_permission',
            'admin_menu_rbac_users'
        ];

        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    function linkSettingsSite($permission){
        switch ($permission){
            case 'admin_menu_rbac_roles':
                $name['title'] = 'Роли пользователей';
                $name['link'] = Url::toRoute('/rbac/roles');
                return $name;

            case 'admin_menu_rbac_permission':
                $name['title'] = 'Расшифровка доступов';
                $name['link'] = Url::toRoute('/rbac/permission');
                return $name;

            case 'admin_menu_rbac_users':
                $name['title'] = 'Пользователи';
                $name['link'] = Url::toRoute('/rbac/users');
                return $name;
            default:
                return false;
        }
    }

    /*  */
    function menuUsers(){
        $permissions = [
            'users_clients',
            'users_moder'
        ];

        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    function linkUsers($permission){
        switch ($permission){

            case 'admin_menu_rbac_permission':
                $name['title'] = 'Ожидание модерации';
                $name['link'] = Url::toRoute('/users/users-moder');
                return $name;

            case 'users_clients':
                $name['title'] = 'Клиенты';
                $name['link'] = Url::toRoute('/users');
                return $name;

            default:
                return false;
        }
    }


    /*
     * можно создать 1 большой массив и по циклу выдирать переменные
     */
}