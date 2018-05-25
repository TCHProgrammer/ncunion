<?php

namespace common\models;

use Yii;
use common\models\object\Object;

/**
 * This is the model class for table "comment_object".
 *
 * @property int $id
 * @property int $object_id
 * @property int $level
 * @property int $comment_id
 * @property int $user_id
 * @property string $user_name
 * @property string $text
 * @property string $datetime
 *
 * @property Object $object
 */
class CommentObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['datetime', 'default', 'value' => date('Y-m-d H:i:s')],
            [['object_id', 'level', 'user_id', 'user_name', 'text', 'datetime'], 'required'],
            [['object_id', 'level', 'comment_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['datetime'], 'safe'],
            [['user_name'], 'string', 'max' => 255],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Object ID',
            'level' => 'Level',
            'comment_id' => 'Comment ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'text' => 'Text',
            'datetime' => 'Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }
}
