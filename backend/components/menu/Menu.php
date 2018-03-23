<?php
namespace backend\components\menu;
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 23.03.2018
 * Time: 16:20
 */

class Menu {
    function link($permission){
        switch ($permission){
            case 'admin_menu_rbac_roles':
                $name['title'] = 'Роли пользователей';
                $name['link'] = '/admin/rbac/roles';
                return $name;

            case 'admin_menu_rbac_permission':
                $name['title'] = 'Расшифровка доступов';
                $name['link'] = '/admin/rbac/permission';
                return $name;

            case 'admin_menu_rbac_users':
                $name['title'] = 'Пользователи';
                $name['link'] = '/admin/rbac/users';
                return $name;
        }
    }


    /*
     * можно создать 1 большой массив и по циклу выдирать переменные
     */
}