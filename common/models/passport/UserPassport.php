<?php

namespace common\models\passport;

use common\models\object\AttributeCheckbox;
use Yii;
use common\models\object\ObjectType;
use common\models\UserModel as User;

/**
 * This is the model class for table "user_passport".
 *
 * @property int $id
 * @property int $type_id
 * @property int $area
 * @property int $rooms
 * @property int $form_participation_id
 * @property string $amount_min
 * @property string $amount_max
 * @property int $area_min
 * @property int $area_max
 * @property int $rooms_min
 * @property int $rooms_max
 *
 * @property PassportAttribute[] $passportAttributes
 * @property User[] $users
 * @property FormParticipation $formParticipation
 * @property ObjectType $type
 */
class UserPassport extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_passport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_participation_id'], 'required'],
            [['form_participation_id', 'area_min', 'area_max', 'rooms_min', 'rooms_max',  'amount_min', 'amount_max', 'area_min', 'area_max', 'rooms_min', 'rooms_max'], 'integer'],
            [['form_participation_id'], 'exist', 'skipOnError' => true, 'targetClass' => FormParticipation::className(), 'targetAttribute' => ['form_participation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_participation_id' => 'Форма участия',
            'amount_min' => 'Мин стоимость',
            'amount_max' => 'Макс стоимость',
            'area_min' => 'Мин площадь',
            'area_max' => 'Макс площадь',
            'rooms_min' => 'Мин колличество комнат',
            'rooms_max' => 'Макс колличество комнат',

        ];
    }

    public function afterSave($insert, $changedAttributes){

        $user = User::findOne(Yii::$app->user->id);

        $user->user_passport_id = $this->id;
        $user->save();

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPassportAttributes()
    {
        return $this->hasMany(PassportAttribute::className(), ['passport_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_passport_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormParticipation()
    {
        return $this->hasOne(FormParticipation::className(), ['id' => 'form_participation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCheckboxs()
    {
        return $this->hasMany(PassportAttributeCheckbox::className(), ['passport_id' => 'id']);
    }

    public function getRadios()
    {
        return $this->hasMany(PassportAttributeRadio::className(), ['passport_id' => 'id']);
    }
}
