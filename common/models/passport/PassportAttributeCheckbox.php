<?php

namespace common\models\passport;

use Yii;
use common\models\object\AttributeCheckbox;
use common\models\object\GroupCheckbox;

/**
 * This is the model class for table "passport_attribute_checkbox".
 *
 * @property int $passport_id
 * @property int $attribute_id
 * @property int $group_id
 *
 * @property UserPassport $passport
 * @property AttributeCheckbox $attribute0
 * @property GroupCheckbox $group
 */
class PassportAttributeCheckbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'passport_attribute_checkbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passport_id', 'attribute_id', 'group_id'], 'integer'],
            [['passport_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPassport::className(), 'targetAttribute' => ['passport_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeCheckbox::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupCheckbox::className(), 'targetAttribute' => ['group_id' => 'id']],
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
        return $this->hasOne(AttributeCheckbox::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GroupCheckbox::className(), ['id' => 'group_id']);
    }
}
