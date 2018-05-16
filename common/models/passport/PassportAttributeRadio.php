<?php

namespace common\models\passport;

use Yii;
use common\models\object\AttributeRadio;
use common\models\object\GroupRadio;

/**
 * This is the model class for table "passport_attribute_radio".
 *
 * @property int $passport_id
 * @property int $attribute_id
 * @property int $group_id
 *
 * @property UserPassport $passport
 * @property AttributeRadio $attribute0
 * @property GroupRadio $group
 */
class PassportAttributeRadio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'passport_attribute_radio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passport_id', 'attribute_id', 'group_id'], 'integer'],
            [['passport_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPassport::className(), 'targetAttribute' => ['passport_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeRadio::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupRadio::className(), 'targetAttribute' => ['group_id' => 'id']],
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
            'group_id' => 'Group ID',
        ];
    }

    public static function primaryKey()
    {
        return [
            'group_id',
            'passport_id'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPassport()
    {
        return $this->hasOne(UserPassport::className(), ['id' => 'passport_id']);
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
    public function getGroup()
    {
        return $this->hasOne(GroupRadio::className(), ['id' => 'group_id']);
    }
}
