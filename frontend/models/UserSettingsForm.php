<?php
namespace frontend\models;
use common\models\UserModel;
use common\models\UserAvatar;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
class UserSettingsForm extends UserModel {

    /* походу этот файл не нужен */

    public $imageFile;

    public function attributeLabels()
    {
        return [
            'avatar' => 'Аватар',
        ];
    }

    public function updateUser($id){
        $user = UserModel::findOne($id);
        $user->avatar = $this->avatar;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->middle_name = $this->middle_name;
        $user->company_name = $this->company_name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->updated_at = time();
        if (!$user->save()) {
            return false;
        }

        $user_avatar = UserAvatar::findOne(['user_id' => $id]);
        if ($user_avatar == null) {
            $user_avatar = new UserAvatar();
            $user_avatar->user_id = $id;
        }


        /*if(!empty($this->avatar)){
            if(!ctype_space($this->avatar)){
                //$user_avatar->avatar = $this->avatar;

                /*if ($user_avatar->avatar){
                    unlink(Yii::getAlias('@frontend/web'.$currentPic));
                    // var_dump('@app'.'/frontend/web'.$currentPic);die;
                }*/
            //}
        //}



        /*$kek= UploadedFile::getInstance($user_avatar, 'imgFiles');
        $fileName = 'uploads/' . $kek->getExtension();
        $user_avatar->avatar = '/'.$fileName;

        $user_avatar->imageFile->saveAs($fileName);*/

        if (!$user_avatar->save()) {
            return false;
        }

        return true;
    }
}