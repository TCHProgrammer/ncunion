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
 * @property int $term
 * @property int $schedule_payments
 * @property int $nks
 * @property string $comment
 *
 * @property User $user
 * @property Object $object
 */
class RoomObjectUser extends \yii\db\ActiveRecord
{
    public $slider_sum;

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
            [['object_id', 'user_id', 'sum', 'rate', 'term', 'schedule_payments', 'nks'], 'required'],
            [['object_id', 'user_id', 'rate', 'term', 'schedule_payments', 'nks', 'created_at', 'active'], 'integer'],
            [['sum'], 'number'],
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
            'comment' => 'Пожелания ',
            'created_at' => 'Дата создания',
            'slider_sum' => 'Сумма',
            'term' => 'Срок',
            'schedule_payments' => 'График палатежей',
            'nks' => 'НКС'
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
