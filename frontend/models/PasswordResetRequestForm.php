<?php
namespace frontend\models;

use common\components\EmailComponent;
use Yii;
use yii\base\Model;
use common\models\User;

class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Нет пользователя с этим адресом электронной почты.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта'
        ];
    }

    public function sendEmail()
    {
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        //var_dump([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot']);die;

        $email = new EmailComponent();

        return $email->passwordResetToken($this->email, $user);

    }
}
