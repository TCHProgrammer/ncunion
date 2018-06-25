<?php
namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\base\Model;
use common\models\User;

class RegPhone extends Model{

    public $code;

    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Код',
        ];
    }

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

    public function regCodePhone()
    {

        $i = 1;
        $code = '';
        while($i <= 6){
            $code .= $this->randNumber();
            $i++;
        }

        return $code;
    }

    private function randNumber(){
        $randNum = rand(0, 9);
        return $randNum;
    }

}