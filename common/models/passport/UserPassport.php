<?php

namespace common\models\passport;

use Yii;
use common\models\object\ObjectType;
use common\models\UserModel as User;

/**
 * This is the model class for table "user_passport".
 *
 * @property int $id
 * @property string $amount
 * @property int $type_id
 * @property int $area
 * @property int $rooms
 * @property int $form_participation_id
 *
 * @property PassportAttribute[] $passportAttributes
 * @property User[] $users
 * @property FormParticipation $formParticipation
 * @property ObjectType $type
 */
class UserPassport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            [['amount', 'type_id', 'form_participation_id'], 'required'],
            [['amount'], 'number'],
            [['type_id', 'form_participation_id', 'area', 'rooms'], 'integer'],
            [['form_participation_id'], 'exist', 'skipOnError' => true, 'targetClass' => FormParticipation::className(), 'targetAttribute' => ['form_participation_id' => 'id']],
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
            'amount' => 'Желаемая сумма участия',
            'type_id' => 'Тип объекта',
            'area' => 'Площадь',
            'rooms' => 'Комнаты',
            'form_participation_id' => 'Форма участия',
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
    public function getType()
    {
        return $this->hasOne(ObjectType::className(), ['id' => 'type_id']);
    }
}
