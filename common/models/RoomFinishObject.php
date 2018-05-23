<?php

namespace common\models;

use Yii;
use common\models\object\Object;

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
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'user_id' => 'User ID',
            'manager_id' => 'Manager ID',
            'created_at' => 'Created At',
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
