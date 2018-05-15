<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "object_attribute_checkbox".
 *
 * @property int $object_id
 * @property int $attribute_id
 * @property int $group_id
 *
 * @property GroupCheckbox $group
 * @property AttributeCheckbox $attribute0
 */
class ObjectAttributeCheckbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_attribute_checkbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'attribute_id', 'group_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupCheckbox::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeCheckbox::className(), 'targetAttribute' => ['attribute_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GroupCheckbox::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(AttributeCheckbox::className(), ['id' => 'attribute_id']);
    }
}
