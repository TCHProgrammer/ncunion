<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "attribute_checkbox".
 *
 * @property int $id
 * @property string $title
 * @property int $type_id
 *
 * @property ObjectType $type
 * @property GroupCheckbox[] $groupCheckboxes
 * @property ObjectAttributeCheckbox[] $objectAttributeCheckboxes
 */
class AttributeCheckbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_checkbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type_id'], 'required'],
            [['type_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'type_id' => 'Тип объекта',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ObjectType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupCheckboxes()
    {
        return $this->hasMany(GroupCheckbox::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectAttributeCheckboxes()
    {
        return $this->hasMany(ObjectAttributeCheckbox::className(), ['attribute_id' => 'id']);
    }
}
