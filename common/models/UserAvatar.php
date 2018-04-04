<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_avatar".
 *
 * @property int $user_id
 * @property string $avatar
 *
 * @property User $user
 */
class UserAvatar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $imageFile;

    public static function tableName()
    {
        return 'user_avatar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['avatar'], 'string', 'max' => 255],
            [['avatar'], 'file', 'extensions' => 'jpg, png', 'message' => 'Поддерживаются только jpg и png форматы' ],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'avatar' => 'Аватар',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function primaryKey()
    {
        return ['user_id'];
    }
}
