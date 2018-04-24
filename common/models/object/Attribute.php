<?php

namespace common\models\object;

use Yii;
use common\models\passport\PassportAttribute;

/**
 * This is the model class for table "attribute".
 *
 * @property int $id
 * @property string $title
 * @property int $type_id
 *
 * @property ObjectAttribute[] $objectAttributes
 * @property PassportAttribute[] $passportAttributes
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute';
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
    public function getObjectAttributes()
    {
        return $this->hasMany(ObjectAttribute::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPassportAttributes()
    {
        return $this->hasMany(PassportAttribute::className(), ['attribute_id' => 'id']);
    }
}
