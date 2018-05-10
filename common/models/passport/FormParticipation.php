<?php

namespace common\models\passport;

use Yii;

/**
 * This is the model class for table "form_participation".
 *
 * @property int $id
 * @property string $title
 *
 * @property UserPassport[] $userPassports
 */
class FormParticipation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_participation';
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
    public function getUserPassports()
    {
        return $this->hasMany(UserPassport::className(), ['form_participation_id' => 'id']);
    }
}
