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
    private $_tagsArray;

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
            [['tagsArray'], 'safe'],
            [['area_min', 'area_max', 'rooms_min', 'rooms_max',  'amount_min', 'amount_max', 'area_min', 'area_max', 'rooms_min', 'rooms_max'], 'integer'],
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
            'tagsArray' => 'Форма участия'
        ];
    }

    public function afterSave($insert, $changedAttributes){

        $user = User::findOne(Yii::$app->user->id);
        if (!isset($user->user_passport_id)){
            $user->user_passport_id = $this->id;
            $user->save();
        }

        $this->updateTags();

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

    public function getParticipation(){
        return $this->hasMany(FormParticipation::className(), ['id' => 'participation_id'])
            ->viaTable('{{%participation_passport}}', ['passport_id' => 'id']);
    }

    public function getTagsArray(){
        if ($this->_tagsArray === null){
            $this->_tagsArray = $this->getParticipation()->select('id')->column();
        }
        return $this->_tagsArray;
    }

    public function setTagsArray($value){
        return $this->_tagsArray = (array)$value;
    }

    public function updateTags(){
        $currentNoticeIds = $this->getParticipation()->select('id')->column();
        $newNoticeIds = $this->tagsArray;

        foreach (array_filter(array_diff($newNoticeIds, $currentNoticeIds)) as $noticeId) {
            if ($notice = FormParticipation::find()->where(['id' => $noticeId])->one()) {
                $this->link('participation', $notice);
            }
        }

        foreach (array_filter(array_diff($currentNoticeIds, $newNoticeIds)) as $noticeId) {
            if ($notice = FormParticipation::find()->where(['id' => $noticeId])->one()) {
                $this->unlink('participation', $notice, true);
            }
        }
    }
}
