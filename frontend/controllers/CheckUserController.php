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

        if (!(isset($user->check_email) && isset($user->check_phone))){


            $model = new RegEmailPhone();

            if(isset(Yii::$app->request->post()['RegEmailPhone']['tokenEmail'])){

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

            $model = new UserPassport();

            if ($model->load(Yii::$app->request->post())) {
                if($model->validate()){
                    if($model->save()){
                        return $this->redirect('/payment/pay');
                    };
                }
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