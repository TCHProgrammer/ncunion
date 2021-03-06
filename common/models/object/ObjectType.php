<?php

namespace common\models\object;

use Yii;
use common\models\passport\UserPassport;

/**
 * This is the model class for table "object_type".
 *
 * @property int $id
 * @property string $title
 *
 * @property Object[] $objects
 * @property UserPassport[] $userPassports
 */
class ObjectType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjects()
    {
        return $this->hasMany(Object::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPassports()
    {
        return $this->hasMany(UserPassport::className(), ['type_id' => 'id']);
    }

    public function getAttributes0()
    {
        return $this->hasMany(Attribute::className(), ['type_id' => 'id']);
    }

    public function getAttributeCheckboxs()
    {
        return $this->hasMany(AttributeCheckbox::className(), ['type_id' => 'id']);
    }

    public function getAttributeRadios()
    {
        return $this->hasMany(AttributeRadio::className(), ['type_id' => 'id']);
    }
}
