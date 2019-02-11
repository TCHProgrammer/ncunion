<?php

namespace common\models;

use backend\modules\rbac\models\AuthAssignment;
use backend\modules\rbac\models\AuthItem;
use Yii;
use common\models\NoticeUser;
use common\models\Notice;
use common\models\passport\UserPassport;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $email_confirm_token
 * @property string $phone_confirm_token
 * @property string $company_name
 * @property string $check_email
 * @property string $check_phone
 * @property string $check_moderator
 * @property string $user_passport_id
 *
 * @property UserAvatar[] $userAvatars
 */
class UserModel extends \yii\db\ActiveRecord
{
    public $avatar;
    public $imageFile;

    public static function tableName()
    {
        return 'user';
    }

    public function afterDelete()
    {
        AuthAssignment::deleteAll(['user_id' => $this->id]);
        return parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['imageFile', 'image', 'extensions' => 'jpg, png'],
            [['tagsArray'], 'safe'],
            [['created_at'], 'default', 'value'=> time()],
            [['updated_at'], 'default', 'value'=> time()],
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'check_email', 'check_phone', 'user_passport_id', 'subscribe_dt'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'middle_name', 'phone', 'company_name', 'avatar'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Электронная почта',
            'status' => 'Статус',
            'subscribe_dt' => 'дата окончания подписки',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата последнего изменения',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'phone' => 'Контактный телефон',
            'company_name' => 'Название компании',
            'check_email' => 'Подтверждение email',
            'check_phone' => 'Подтверждение телефона',
            'role' => 'Роль',
            'tagsArray' => 'Уведомления по почте',
            'imageFile' => 'Загрузить изображение'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUserAvatars()
    {
        return $this->hasMany(UserAvatar::className(), ['user_id' => 'id']);
    }

    public function getRoles()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function getNotice()
    {
        return $this->hasMany(Notice::className(), ['id' => 'notice_id'])
            ->viaTable('{{%notice_user}}', ['user_id' => 'id']);
    }

    public function getNoticeUsers()
    {
        return $this->hasMany(NoticeUser::className(), ['user_id' => 'id']);
    }

    public function getUserPassport()
    {
        return$this->hasOne(UserPassport::className(), ['id' => 'user_passport_id']);
    }

    private $_tagsArray;

    public function getTagsArray()
    {
        if ($this->_tagsArray === null) {
            $this->_tagsArray = $this->getNotice()->select('id')->column();
        }
        return $this->_tagsArray;
    }

    public function setTagsArray($value){
        return $this->_tagsArray = (array)$value;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateNotices();
        parent::afterSave($insert, $changedAttributes);
    }

    private function updateNotices()
    {
        $currentNoticeIds = $this->getNotice()->select('id')->column();
        $newNoticeIds = $this->getTagsArray();

        foreach (array_filter(array_diff($newNoticeIds, $currentNoticeIds)) as $noticeId) {
            if ($notice = Notice::find()->where(['id' => $noticeId])->one()) {
                $this->link('notice', $notice);
            }
        }

        foreach (array_filter(array_diff($currentNoticeIds, $newNoticeIds)) as $noticeId) {
            if ($notice = Notice::find()->where(['id' => $noticeId])->one()) {
                $this->unlink('notice', $notice, true);
            }
        }
    }

    /* изменить пароль  */
    public function updatePassword($id){
        $user = UserModel::findOne($id);
        $post = Yii::$app->request->post('UpdatePassword');
        if ($user && $post && ($post['password'] == $post['password_repeat'])){
            if (Yii::$app->security->validatePassword($post['password'], $this->password_hash)){
                $user->password_hash = Yii::$app->security->generatePasswordHash($post['password_new']);
                if($user->save()){
                    return true;
                };
            }
        }
        return false;
    }

    /* формирования телефона */

}
