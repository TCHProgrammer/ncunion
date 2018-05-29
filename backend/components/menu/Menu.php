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
            'admin_menu_rbac_users',
            'info_site',
            'settings_add_email_push'
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

            case 'info_site':
                $name['title'] = 'Общая информация';
                $name['link'] = Url::toRoute('/info-site/index');
                return $name;

            case 'settings_add_email_push':
                $name['title'] = 'Почтовые уведомления';
                $name['link'] = Url::toRoute('/notice/index');
                return $name;

            default:
                return false;
        }
    }

    /* Пользователи */
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

    /* Объекты */
    function menuObject(){
        $permissions = [
            'can_create_object',
            'can_check_finish_object',
        ];

        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    function linkObject($permission){
        switch ($permission){

            case 'can_create_object':
                $name['title'] = 'Объекты';
                $name['link'] = Url::toRoute('/object');
                return $name;

            case 'can_check_finish_object':
                $name['title'] = 'Завершённые объекты';
                $name['link'] = Url::toRoute('/object-finish');
                return $name;

            default:
                return false;
        }
    }

    /*
     * можно создать 1 большой массив и по циклу выдирать переменные
     */
}