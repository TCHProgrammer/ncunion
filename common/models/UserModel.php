<?php

namespace common\models;

use backend\modules\rbac\models\AuthAssignment;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $company_name
 * @property string $check_email
 * @property string $check_phone
 * @property string $check_moderator
 *
 * @property UserAvatar[] $userAvatars
 */
class UserModel extends \yii\db\ActiveRecord
{
    public $avatar;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'middle_name', 'phone', 'company_name', 'avatar'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Электронная почта',
            'status' => 'Статус',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата последнего изменения',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'phone' => 'Контактный телефон',
            'company_name' => 'Название компании',
            'check_email' => 'Подтверждение email',
            'check_phone' => 'Подтверждение телефона',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUserAvatars()
    {
        return $this->hasMany(UserAvatar::className(), ['user_id' => 'id']);
    }

    public function getRoles()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }
}
