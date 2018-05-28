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
use common\models\passport\PassportAttribute;
use common\models\passport\UserPassport;
use frontend\components\controllers\DefaultFrontendController;
use common\models\UserAvatar;
use frontend\models\UpdatePassword;
use yii\filters\AccessControl;
use frontend\models\UserSettingsForm;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\web\Controller;
use common\models\UserModel;
use common\models\object\AttributeCheckbox;
use common\models\object\AttributeRadio;
use common\models\passport\PassportAttributeCheckbox;
use common\models\passport\PassportAttributeRadio;

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
        $updatePas = new UpdatePassword();

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
            'updatePas' => $updatePas
        ]);
    }

    public function actionPassport(){

        $user = UserModel::find()->where(['id' => Yii::$app->user->id])->select('user_passport_id')->one();
        $model = $this->findPassport($user->user_passport_id);

        $listValue = AttributeCheckbox::find()->all();
        $modelValue = PassportAttribute::find()->where(['passport_id' => $user->user_passport_id])->all();
        $rezValue = [];
        foreach ($modelValue as $item){
            $rezValue[] .= $item->attribute_id;
        }

        $listCheckbox = AttributeCheckbox::find()->joinWith('groupCheckboxes')->all();
        $modelCheckbox = PassportAttributeCheckbox::find()->where(['passport_id' => $user->user_passport_id])->all();
        $rezCheckbox = [];
        foreach ($modelCheckbox as $item){
            $rezCheckbox[] .= $item->group_id;
        }

        $listRadio = AttributeRadio::find()->joinWith('groupRadios')->all();
        $modelRadio = PassportAttributeRadio::find()->where(['passport_id' => $user->user_passport_id])->all();
        $rezRadio = [];
        foreach ($modelRadio as $item){
            $rezRadio[] .= $item->group_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if ($model->save()){

                $this->saveText(Yii::$app->request->post('GroupValue')[$model->type_id], $model);
                $this->saveCheckbox(Yii::$app->request->post('GroupCheckboxes')[$model->type_id], $model);
                $this->saveRadio(Yii::$app->request->post('GroupRadios')[$model->type_id], $model);

                //return $this->redirect('profile');
                return $this->redirect('passport');
            }
        }

        return $this->render('passport', [
            'model' => $model,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio,
            'listValue' => $listValue,
            'rezValue' => $rezValue,
        ]);
    }

    /**
     * Изменить пароль
     */
    public function actionUpdatePassword(){
        $id = Yii::$app->user->id;
        $user = $this->findModel($id);
        if($user->updatePassword($id)){
            Yii::$app->session->setFlash('success', 'Пароль успешно был изменён.');
            return $this->redirect('profile');
        }else{
            Yii::$app->session->setFlash('error','Пароль не был изменён, вы ввели неправильный пароль.');
            return $this->redirect('settings');
        }
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

    /**
     * Сохраниение text
     */
    private function saveText($groups, $model){

        $listModel = PassportAttribute::find()->where(['passport_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item){
            $arrListGroups[] .= $item->attribute_id;
        }

        $delArr = [];
        if ($groups){
            foreach ($groups as $id => $group){
                foreach ($group as $item){
                    if (!in_array($item, $arrListGroups)){
                        $addNewAttr = new PassportAttribute();
                        $addNewAttr->passport_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->value = $item;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }else{
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item,$arrListGroups)]);
                    }
                }
            }
        }

        foreach ($arrListGroups as $arrListGroup) {
            $delModel = PassportAttributeCheckbox::find()
                ->where(['passport_id' => $model->id])
                ->andWhere(['attribute_id' => $arrListGroup])
                ->one();
            if ($delModel) {
                $delModel->delete(['passport_id' => $model->id, 'attribute_id' => $arrListGroup]);
            }
        }
    }

    /**
     * Сохраниение checkbox
     */
    private function saveCheckbox($groups, $model){

        $listModel = PassportAttributeCheckbox::find()->where(['passport_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item){
            $arrListGroups[] .= $item->group_id;
        }

        $delArr = [];
        if ($groups){
            foreach ($groups as $id => $group){
                foreach ($group as $item){
                    if (!in_array($item, $arrListGroups)){
                        $addNewAttr = new PassportAttributeCheckbox();
                        $addNewAttr->passport_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }else{
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item,$arrListGroups)]);
                    }
                }
            }
        }

        foreach ($arrListGroups as $arrListGroup) {
            $delModel = PassportAttributeCheckbox::find()
                ->where(['passport_id' => $model->id])
                ->andWhere(['group_id' => $arrListGroup])
                ->one();
            if ($delModel) {
                $delModel->delete(['passport_id' => $model->id, 'group_id' => $arrListGroup]);
            }
        }
    }

    /**
     * Сохраниение radio
     */
    private function saveRadio($groups, $model){

        $listModel = PassportAttributeRadio::find()->where(['passport_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item) {
            $arrListGroups[] .= $item->group_id;
        }

        $delArr = [];
        if ($groups) {
            foreach ($groups as $id => $group) {
                foreach ($group as $item) {
                    if (!in_array($item, $arrListGroups)) {
                        $addNewAttr = new PassportAttributeRadio();
                        $addNewAttr->passport_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if ($addNewAttr->validate()) {
                            $addNewAttr->save();
                        }
                    } else {
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item, $arrListGroups)]);
                    }
                }
            }
        }

        foreach ($arrListGroups as $arrListGroup) {
            $delModel = PassportAttributeRadio::find()
                ->where(['passport_id' => $model->id])
                ->andWhere(['group_id' => $arrListGroup])
                ->one();
            if ($delModel) {
                $delModel->delete(['passport_id' => $model->id, 'group_id' => $arrListGroup]);
            }
        }
    }

}