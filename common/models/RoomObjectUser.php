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
 * @property int $active
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
            [['object_id', 'user_id', 'sum', 'consumption', 'rate'], 'required'],
            [['object_id', 'user_id', 'sum', 'rate', 'consumption', 'created_at', 'active'], 'integer'],
            [['created_at'], 'default', 'value' => time()],
            [['active'], 'default', 'value' => 0],
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
            'active' => 'Проверка инвестора',
            'rate' => 'Ставка',
            'consumption' => 'Расход по сделке',
            'comment' => 'Пожелания ',
            'created_at' => 'Дата создания'
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

    public function getUserAvatar()
    {
        return $this->hasOne(UserAvatar::className(), ['user_id' => 'user_id']);
    }

}
