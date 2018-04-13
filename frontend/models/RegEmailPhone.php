<?php
namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\base\Model;
use common\models\User;

class RegEmailPhone extends Model{

    public $tokenEmail;
    public $tokenPhone;

    public function checkEmail(){
        $user = User::findOne(Yii::$app->user->id);

        if (!$user) {
            return false;
        }

        $user->generateEmailConfirmToken();
        if (!$user->save()) {
            return false;
        }

        $contentMas = [
            'userName' => $user->first_name,
            'link' => Url::home(true).'/check-user/email?token=' . $user->email_confirm_token,
        ];

        return Yii::$app->email->checkEmailUser($user->email, $contentMas);


    }

}