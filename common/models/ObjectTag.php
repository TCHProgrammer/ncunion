<?php

namespace common\models;

use Yii;
use common\models\object\Object;

/**
 * This is the model class for table "object_tag".
 *
 * @property int $object_id
 * @property int $tag_id
 *
 * @property Object $object
 * @property Tag $tag
 */
class ObjectTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'tag_id'], 'required'],
            [['object_id', 'tag_id'], 'integer'],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
