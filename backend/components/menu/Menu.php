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

    /* Объекты */
    function menuObject(){
        $permissions = [
            'can_create_object',
        ];

        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    /* Тариф */
    function menuTariff(){
        $permissions = [
            'can_module_tariff',
        ];

        foreach ($permissions as $permission) {
            if (Yii::$app->user->can($permission)) {
                return true;
            }
        }

        return false;
    }
}