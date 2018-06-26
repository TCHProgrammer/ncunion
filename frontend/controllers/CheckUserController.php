<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 02.04.2018
 * Time: 18:34
 */

namespace frontend\controllers;

use yii\filters\AccessControl;
use Yii;
use yii\web\Controller;
use common\models\UserModel;
use frontend\models\RegEmail;
use frontend\models\RegPhone;
use common\components\Smsc;

class CheckUserController extends Controller{

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['unknown']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/login']);
                }
            ],
        ];
    }

    /* 3 пути: подтверждение, паспорт, ожидание модерации */
    public function actionIndex(){

        $user_id = Yii::$app->user->id;
        $user = UserModel::findOne($user_id);

        if (!($user->check_email && $user->check_phone)){

            $model = new RegEmail();

            if(isset(Yii::$app->request->post()['RegEmail']['tokenEmail'])){

                if($model->checkEmail()){
                    Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для для активации аккаунта.');
                }else{
                    Yii::$app->session->setFlash('success', 'Произошла ошибка.');
                }

            };

            return $this->render('check-email-phone', [
                'model' => $model
            ]);

        //тут чекам профиль из паспорта, если есть то гуд
        }elseif (is_null($user->user_passport_id)){
            return $this->redirect('/user/create-password');
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
        }else{
            Yii::$app->session->setFlash('success', 'Произошла ошибка. Неверный токен, потвердите вашу почту ещё раз.');
            return $this->redirect('/check-user');
        }
    }

    public function actionPhone()
    {
        $model = new RegPhone();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = UserModel::findOne(Yii::$app->user->id);
            if ($user->phone_confirm_token == $model->code){
                $user->phone_confirm_token = null;
                $user->check_phone = 1;
                if ($user->update()){
                    Yii::$app->session->setFlash('success', 'Ваш телефон успешно подтвержден.');
                    return $this->redirect('/check-user');
                }else{
                    Yii::$app->session->setFlash('error', 'Возникла внутренняя ошибка сервера. Пользователь не найден.');
                    return $this->redirect('phone');
                }
            }
            Yii::$app->session->setFlash('error', 'Вы ввели неверный код.');
            return $this->redirect('phone');
        };

        return $this->render('phone', [
            'model' => $model
        ]);
    }

    public function actionPushPhone()
    {
        $model = new RegPhone();

        /* генерируем code */
        $code = $model->regCodePhone();
        if (!isset($code)){ return false; };

        /* находим пользователя и записываем code */
        $user = UserModel::findOne(Yii::$app->user->id);
        if (!isset($user)){ return false; };
        $user->phone_confirm_token = $code;

        if ($user->validate() && $user->update()){
            /*отправляем письмо по смс*/
            $sms = new Smsc();
            if ($sms->pushSms($user->phone, $code)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}