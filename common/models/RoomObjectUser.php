<?php

namespace common\models;

use Yii;
use common\models\UserModel as User;
use common\models\object\Object;

/**
 * This is the model class for table "room_object_user".
 *
 * @property int $object_id
 * @property int $user_id
 * @property int $sum
 * @property int $rate
 * @property int $consumption
 * @property string $comment
 *
 * @property User $user
 * @property Object $object
 */
class RoomObjectUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room_object_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'user_id', 'sum', 'consumption'], 'required'],
            [['object_id', 'user_id', 'sum', 'rate', 'consumption'], 'integer'],
            [['comment'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'user_id' => 'User ID',
            'sum' => 'Сумма',
            'rate' => 'Ставка',
            'consumption' => 'Consumption',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }
}
