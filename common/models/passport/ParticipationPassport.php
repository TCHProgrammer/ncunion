<?php

namespace common\models\passport;

use Yii;

/**
 * This is the model class for table "participation_passport".
 *
 * @property int $id
 * @property int $participation_id
 * @property int $passport_id
 *
 * @property FormParticipation $participation
 * @property UserPassport $passport
 */
class ParticipationPassport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participation_passport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['participation_id', 'passport_id'], 'integer'],
            [['participation_id'], 'exist', 'skipOnError' => true, 'targetClass' => FormParticipation::className(), 'targetAttribute' => ['participation_id' => 'id']],
            [['passport_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPassport::className(), 'targetAttribute' => ['passport_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'participation_id' => Yii::t('app', 'Participation ID'),
            'passport_id' => Yii::t('app', 'Passport ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipation()
    {
        return $this->hasOne(FormParticipation::className(), ['id' => 'participation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPassport()
    {
        return $this->hasOne(UserPassport::className(), ['id' => 'passport_id']);
    }
}
