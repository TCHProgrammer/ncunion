<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "object_attribute".
 *
 * @property int $object_id
 * @property int $attribute_id
 * @property string $value
 *
 * @property Attribute $attribute0
 * @property Object $object
 */
class ObjectAttribute extends \yii\db\ActiveRecord
{

    const SCENARIO_TABULAR = 'tabular';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'attribute_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    public static function primaryKey()
    {
        return [
            'object_id',
            'attribute_id'
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
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttribute0()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }
}
