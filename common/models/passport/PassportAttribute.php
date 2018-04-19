<?php

namespace common\models\passport;

use Yii;
use common\models\object\Attribute;

/**
 * This is the model class for table "passport_attribute".
 *
 * @property int $passport_id
 * @property int $attribute_id
 * @property string $value
 *
 * @property Attribute $attribute0
 * @property UserPassport $passport
 */
class PassportAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'passport_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passport_id', 'attribute_id', 'value'], 'required'],
            [['passport_id', 'attribute_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['passport_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPassport::className(), 'targetAttribute' => ['passport_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'passport_id' => 'Passport ID',
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
    public function getPassport()
    {
        return $this->hasOne(UserPassport::className(), ['id' => 'passport_id']);
    }
}
