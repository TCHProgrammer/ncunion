<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "object_attribute_radio".
 *
 * @property int $object_id
 * @property int $attribute_id
 * @property int $group_id
 *
 * @property GroupRadio $group
 * @property AttributeRadio $attribute0
 */
class ObjectAttributeRadio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_attribute_radio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'attribute_id', 'group_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupRadio::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeRadio::className(), 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'attribute_id' => 'Attribute ID',
            'group_id' => 'Group ID',
        ];
    }

    public static function primaryKey()
    {
        return [
            'group_id',
            'object_id'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GroupRadio::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(AttributeRadio::className(), ['id' => 'attribute_id']);
    }
}
