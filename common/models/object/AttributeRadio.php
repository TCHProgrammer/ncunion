<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "attribute_radio".
 *
 * @property int $id
 * @property string $title
 * @property int $type_id
 *
 * @property ObjectType $type
 * @property GroupRadio[] $groupRadios
 * @property ObjectAttributeRadio[] $objectAttributeRadios
 */
class AttributeRadio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_radio';
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
    public function getGroupRadios()
    {
        return $this->hasMany(GroupRadio::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectAttributeRadios()
    {
        return $this->hasMany(ObjectAttributeRadio::className(), ['attribute_id' => 'id']);
    }
}
