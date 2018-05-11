<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 02.04.2018
 * Time: 18:34
 */

namespace frontend\controllers;

use common\models\Notice;
use common\models\NoticeUser;
use common\models\passport\UserPassport;
use frontend\components\controllers\DefaultFrontendController;
use common\models\UserAvatar;
use yii\filters\AccessControl;
use frontend\models\UserSettingsForm;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\web\Controller;
use common\models\UserModel;

class UserController extends DefaultFrontendController{


    const file_name_length = 8;

    public function actionProfile(){

        $user = UserModel::findOne(Yii::$app->user->id);
        $userAvatar = UserAvatar::findOne(Yii::$app->user->id);
        //$user = UserModel::find()->where(['id' => Yii::$app->user->id])->leftJoin('user_avatar', 'user_avatar.user_id = user.id');

        return $this->render('profile', [
            'user' => $user,
            'userAvatar' => $userAvatar
        ]);
    }

    public function actionSettings(){

        //$model = UserSettingsForm::findOne(Yii::$app->user->id);
        $model = $this->findModel(Yii::$app->user->id);

        $avatar = UserAvatar::findOne(['user_id' => Yii::$app->user->id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            /*$svaz = new NoticeUser([
                'notice_id' => 1,
                'user_id' => Yii::$app->user->id,
            ]);
            $svaz->save();*/

            if($_FILES['UserModel']['name']['imageFile']) {
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

            return $this->redirect('profile');
        }

        return $this->render('settings', [
            'model' => $model,
            'avatar' => $avatar,
        ]);
    }

    public function actionPassport(){

        $user = UserModel::find()->where(['id' => Yii::$app->user->id])->select('user_passport_id')->one();
        $model = $this->findPassport($user->user_passport_id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if ($model->save()){
                return $this->redirect('profile');
            }
        }

        return $this->render('passport', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPassport($id)
    {
        if (($model = UserPassport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}