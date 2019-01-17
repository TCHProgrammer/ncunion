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
use common\models\object\Attribute;
use common\models\object\Object;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

class UserController extends DefaultFrontendController{

    const file_name_length = 8;

    public $layout = "user_layout";

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['unknown', 'no_pay', 'user', 'admin', 'broker']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/login']);
                }
            ],
        ];
    }

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

        if (is_null($user->user_passport_id)){
            return $this->redirect('create-password');
        }

        $model = $this->findPassport($user->user_passport_id);

        $objectTypeList = ArrayHelper::map(ObjectType::find()->all(), 'id', 'title');

        /* min и max фильтр */
        $filter = $this->filter();

        $listValue = Attribute::find()->all();
        $modelValue = PassportAttribute::find()->where(['passport_id' => $user->user_passport_id])->all();
        $rezValue = [];
        foreach ($modelValue as $item){
            $rezValue[$item->attribute_id] = $item->value;
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
                $this->saveCheckbosRadio($objectTypeList, $model);
                return $this->redirect('passport');
            }
        }

        return $this->render('passport', [
            'model' => $model,
            'objectTypeList' => $objectTypeList,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio,
            'listValue' => $listValue,
            'rezValue' => $rezValue,
            'filter' => $filter
        ]);
    }

    public function actionCreatePassword(){
        $user = UserModel::find()->where(['id' => Yii::$app->user->id])->select('user_passport_id')->one();
        $model = new UserPassport();

        $objectTypeList = ArrayHelper::map(ObjectType::find()->all(), 'id', 'title');

        /* min и max фильтр */
        $filter = $this->filter();

        $listValue = Attribute::find()->all();

        $listCheckbox = AttributeCheckbox::find()->all();

        $listRadio = AttributeRadio::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if ($model->save()){
                $this->saveCheckbosRadio($objectTypeList, $model);
                return $this->redirect('/check-user');
            }
        }
        $rezCheckbox = [];
        $rezRadio = [];
        $rezValue = [];

        return $this->render('passport', [
            'model' => $model,
            'objectTypeList' => $objectTypeList,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio,
            'listValue' => $listValue,
            'rezValue' => $rezValue,
            'filter' => $filter
        ]);
    }

    /**
     * Сохранение четбоксов и тд.
     */
    private function saveCheckbosRadio($objectTypeList, $model){

        /* не обновлял */
        /*$itmValue = Yii::$app->request->post('GroupValue');
        if (isset($itmValue)) {
            foreach ($itmValue as $typeId => $item){
                $this->saveText($itmValue[$typeId], $model);
            }
        }*/

        $itmCheckboxes = Yii::$app->request->post('GroupCheckboxes');
        if (!isset($itmCheckboxes)){
            $itmCheckboxes = [];
        }
        foreach ($objectTypeList as $typeId => $item) {
            if (array_key_exists($typeId, $itmCheckboxes)){
                $res = $itmCheckboxes[$typeId];
            }else{
                $res = [];
            }
            $this->saveCheckbox($res, $typeId, $model);
        }

        $itmRadios = Yii::$app->request->post('GroupRadios');
        if (!isset($itmRadios)){
            $itmRadios = [];
        }
        foreach ($objectTypeList as $typeId => $item) {
            if (array_key_exists($typeId, $itmRadios)){
                $res = $itmRadios[$typeId];
            }else{
                $res = [];
            }
            $this->saveRadio($res, $typeId, $model);
        }
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
        /* не обновлял */
        $listModel = PassportAttribute::find()->where(['passport_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item){
            $arrListGroups[] .= $item->value;
        }

        $delArr = [];
        if ($groups){
            foreach ($groups as $id => $group){
                foreach ($group as $itemG){
                    if (!in_array($itemG, $arrListGroups)){
                        $addNewAttr = new PassportAttribute();
                        $addNewAttr->passport_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->value = $itemG;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }else{
                        $delArr[] .= $itemG;
                        unset($arrListGroups[array_search($itemG,$arrListGroups)]);
                    }
                }
            }
        }

        foreach ($arrListGroups as $arrListGroup) {
            $delModel = PassportAttribute::find()
                ->where(['passport_id' => $model->id])
                ->andWhere(['value' => $arrListGroup])
                ->one();
            if ($delModel) {
                $delModel->delete(['passport_id' => $model->id, 'value' => $arrListGroup]);
            }
        }

    }

    /**
     * Сохраниение checkbox
     */
    private function saveCheckbox($groups, $typeId, $model){

        $listModel = PassportAttributeCheckbox::find()
            ->where(['passport_id' => $model->id]);

        $filter = ['or'];
        $attributes = AttributeCheckbox::find()->where(['type_id' => $typeId])->all();
        if (!empty($attributes)){
            foreach ($attributes as $item){
                $filter[] = ['attribute_id' => $item->id];
            }
        }else{
            $filter[] = ['attribute_id' => 0];
        }
        $listModel->andFilterWhere($filter);
        $listModel = $listModel->all();

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
    private function saveRadio($groups, $typeId, $model){

        $listModel = PassportAttributeRadio::find()
            ->where(['passport_id' => $model->id]);

        $filter = ['or'];
        $attributes = AttributeRadio::find()->where(['type_id' => $typeId])->all();
        if (!empty($attributes)){
            foreach ($attributes as $item){
                $filter[] = ['attribute_id' => $item->id];
            }
        }else{
            $filter[] = ['attribute_id' => 0];
        }
        $listModel->andFilterWhere($filter);
        $listModel = $listModel->all();
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

    private function filter(){
        $objectPriceMin = Object::find()->select('amount')->orderBy('amount ASC')->one();
        $objectPriceMax = Object::find()->select('amount')->orderBy('amount DESC')->one();

        $objectAreaMin = Object::find()->select('area')->orderBy('area ASC')->one();
        $objectAreaMax = Object::find()->select('area')->orderBy('area DESC')->one();

        $objectRoomMins = Object::find()->select('rooms')->orderBy('rooms ASC')->one();
        $objectRoomMaxs = Object::find()->select('rooms')->orderBy('rooms DESC')->one();

        $filter = [
            'ObjectSearch' => [
                'amount_min' => (int)$objectPriceMin->amount,
                'amount_max' => (int)$objectPriceMax->amount,
                'area_min' => (int)$objectAreaMin->area,
                'area_max' => (int)$objectAreaMax->area,
                'rooms_min' => (int)$objectRoomMins->rooms,
                'rooms_max' => (int)$objectRoomMaxs->rooms,
            ]
        ];

        return $filter;
    }
}