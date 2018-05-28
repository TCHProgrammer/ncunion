<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\UserModel;

class UpdatePassword extends Model{

    public $password;
    public $password_repeat;
    public $password_new;

    public function rules()
    {
        return [
            [['password', 'password_repeat', 'password_new'], 'required'],
            [['password', 'password_repeat', 'password_new'], 'string', 'min' => 6, 'max' => 30],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message'=>'Введенные пароли не совпадают.'],
            [['password'], 'compare', 'compareAttribute' => 'password_repeat', 'message'=>'Введенные пароли не совпадают.']
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Старый пароль',
            'password_repeat' => 'Повторите старый пароль',
            'password_new' => 'Новый пароль'
        ];
    }



}