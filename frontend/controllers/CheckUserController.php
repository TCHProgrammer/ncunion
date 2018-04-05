<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 02.04.2018
 * Time: 18:34
 */

namespace frontend\controllers;

use common\models\UserAvatar;
use yii\filters\AccessControl;
use frontend\models\UserSettingsForm;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\web\Controller;
use common\models\UserModel;

class CheckUserController extends Controller{

    /* 3 пути: подтверждение, паспорт, ожидание модерации */
    public function actionIndex(){

        $user_id = Yii::$app->user->id;
        $user = UserModel::findOne($user_id);
        //$role = array_shift(Yii::$app->authManager->getRolesByUser($user_id))->name;
        $d = Yii::$app->user->can('user');
        $k = Yii::$app->user->can('unknown');

        //тут чекам профиль из паспорта, если есть то гуд
        $passport_user = [1,12,3];

        if (!($user->check_email && $user->check_phone)){
            $check = $user->check_email.$user->check_phone;
            switch ($check){
                case '01':
                    $text = 'Подтвердите email';
                    break;
                case '10':
                    $text = 'Подтвердите телефон';
                    break;
                default:
                    $text = 'Подтвердите email и телефон';
                    break;
            }
            return $this->render('check-email-phone', ['text' => $text]);
        }elseif (is_null($passport_user)){
            return $this->render('passport');
        }elseif (Yii::$app->user->can('no_pay') || Yii::$app->user->can('user')){
            return $this->redirect('/payment/pay');
        }

        return $this->render('expectation');
    }

}