<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "group_checkbox".
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $title
 *
 * @property AttributeCheckbox $attribute0
 * @property ObjectAttributeCheckbox[] $objectAttributeCheckboxes
 */
class GroupCheckbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_checkbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'title'], 'required'],
            [['attribute_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeCheckbox::className(), 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute_id' => 'Атрибут',
            'title' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(AttributeCheckbox::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectAttributeCheckboxes()
    {
        return $this->hasMany(ObjectAttributeCheckbox::className(), ['group_id' => 'id']);
    }
}
