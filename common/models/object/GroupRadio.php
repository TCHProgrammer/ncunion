<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "group_radio".
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $title
 *
 * @property AttributeRadio $attribute0
 * @property ObjectAttributeRadio[] $objectAttributeRadios
 */
class GroupRadio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_radio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id'], 'required'],
            [['attribute_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeRadio::className(), 'targetAttribute' => ['attribute_id' => 'id']],
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
        return $this->hasOne(AttributeRadio::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectAttributeRadios()
    {
        return $this->hasMany(ObjectAttributeRadio::className(), ['group_id' => 'id']);
    }
}
