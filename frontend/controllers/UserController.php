<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 02.04.2018
 * Time: 18:34
 */

namespace frontend\controllers;

use common\models\UserAvatar;
use frontend\models\UserSettingsForm;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\web\Controller;
use common\models\UserModel;

class UserController extends Controller{

    const file_name_length = 8;

    public function actionProfile(){

        $user = UserModel::findOne(Yii::$app->user->id);

        return $this->render('profile', [
            'user' => $user
        ]);
    }

    public function actionSettings(){

        /*$model = UserSettingsForm::findOne(Yii::$app->user->id);
        $avatar = UserAvatar::findOne(['user_id' => Yii::$app->user->id]);
        //var_dump($_POST['UserSettingsForm']);die;

        if (isset($_POST['UserSettingsForm'])){

            $model->attributes = Yii::$app->request->post('UserSettingsForm');
            $model->attributes['avatar'] = $_POST['UserSettingsForm']['avatar'];

            //проверка правил валидации и запись пользователя в бд
            if ($model->validate() && $model->updateUser(Yii::$app->user->id)){
                return $this->goHome();
            }
        }*/









        $model = UserSettingsForm::findOne(Yii::$app->user->id);
        $avatar = UserAvatar::findOne(['user_id' => Yii::$app->user->id]);

        if ($model->load(Yii::$app->request->post())) {

            if($_FILES['UserSettingsForm']['name']['imageFile']) {
                $user_avatar = UserAvatar::findOne(['user_id' => Yii::$app->user->id]);
                if ($user_avatar == null) {
                    $user_avatar = new UserAvatar();
                    $user_avatar->user_id = Yii::$app->user->id;
                } else {
                    unlink(Yii::getAlias('@frontend/web' . $user_avatar->avatar));
                    rmdir('uploads/users/' . Yii::$app->user->id);
                }

                mkdir('uploads/users/' . Yii::$app->user->id);

                $user_avatar->imageFile = UploadedFile::getInstance($model, 'imageFile');

                $fileNameImg = 'uploads/users/' . Yii::$app->user->id . '/' .Yii::$app->security->generateRandomString(self::file_name_length) . '.' . $user_avatar->imageFile->getExtension();
                $user_avatar->avatar = '/' . $fileNameImg;

                $user_avatar->imageFile->saveAs($fileNameImg);

                $user_avatar->save();
            }
        }

        return $this->render('settings', [
            'model' => $model,
            'avatar' => $avatar
        ]);
    }

    /*protected function findModel($id)
    {
        if (($model = UserSettingsForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }*/


    /* ждём подтверждения */

}