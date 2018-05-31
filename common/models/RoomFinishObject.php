<?php

namespace common\models;

use Yii;
use common\models\object\Object;
use common\models\UserModel;

/**
 * This is the model class for table "room_finish_object".
 *
 * @property int $object_id
 * @property int $user_id
 * @property int $manager_id
 * @property int $created_at
 * @property string $comment
 *
 * @property User $user
 * @property Object $object
 */
class RoomFinishObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room_finish_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'user_id'], 'required'],
            [['object_id', 'user_id', 'manager_id', 'created_at'], 'integer'],
            [['created_at'], 'default', 'value' => time()],
            [['comment'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object' => 'Объект',
            'user' => 'Пользователь',
            'manager' => 'Отдал сделку менеджер',
            'user_id' => 'Пользователь',
            'manager_id' => 'Менеджер',
            'created_at' => 'Дата закрытия сделки',
            'comment' => 'Комментарий',
        ];
    }

    public static function primaryKey()
    {
        return [
            'object_id',
            'user_id'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjects()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }
}
