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
use frontend\models\RegEmailPhone;
use common\models\passport\UserPassport;

class CheckUserController extends Controller{

    ///ВАЖНО НАПИСАТЬ РОЛИ!!!!! ИХ ТУТ НЕТ !!!!

    /* 3 пути: подтверждение, паспорт, ожидание модерации */
    public function actionIndex(){

        $user_id = Yii::$app->user->id;
        $user = UserModel::findOne($user_id);

        //тут чекам профиль из паспорта, если есть то гуд
        $passport_user = UserPassport::findOne($user_id);

        if (!($user->check_email && $user->check_phone)){


            $model = new RegEmailPhone();

            if(Yii::$app->request->post()['RegEmailPhone']['tokenEmail']){

                if($model->checkEmail()){
                    Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для для активации аккаунта.');
                }else{
                    Yii::$app->session->setFlash('success', 'Произошла ошибка.');
                }

            };

            return $this->render('check-email-phone', [
                'model' => $model
            ]);
        }elseif (is_null($passport_user)){

            $model = new UserPassport();

            if ($model->load(Yii::$app->request->post())) {
                if($model->validate()){
                    $model->save();
                    //он вроде как сохраняет, но надо сделать ещё правильную выбору(что паспорт у клиента имеется) и
                    // и нужно сохранить id паспорта в столбик с id юзера
                }
                /*if($model->save()){
                    return $this->redirect('/payment/pay');
                };*/
            }

            return $this->render('passport', [
                'model' => $model,
            ]);

        }elseif (Yii::$app->user->can('no_pay') || Yii::$app->user->can('user')){
            return $this->redirect('/payment/pay');
        }


        return $this->render('expectation');
    }

    public function actionEmail($token){

        $user = UserModel::findOne(Yii::$app->user->id);

        if($user->email_confirm_token == $token){
            $user->check_email = 1;
            $user->email_confirm_token = null;
            if ($user->save()){
                $text = 'Электронная почта была успешно подтверждена!';
            }else{
                $text = 'Ошибка! Электронная почта не подтверждена!';
            }
            return $this->render('email', [
                'text' => $text
            ]);
        }
    }
}