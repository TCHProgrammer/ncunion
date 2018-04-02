<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 02.04.2018
 * Time: 18:34
 */

namespace frontend\controllers;

use yii\web\Controller;

class UserController extends Controller
{
    public function actionProfile()
    {
        return $this->render('profile');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }
}