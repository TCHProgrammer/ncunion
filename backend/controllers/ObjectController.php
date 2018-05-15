<?php

namespace backend\controllers;

use Yii;
use common\models\object\Object;
use backend\models\ObjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\controllers\DefaultBackendController;
use yii\filters\AccessControl;
use common\models\object\ObjectAttribute;
use common\models\object\Attribute;
use yii\base\Model;
use common\models\object\ObjectImg;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\helpers\FileHelper;
use yii\web\Response;
use yii\web\UploadedFile;
use common\models\object\ObjectFile;
use common\models\object\AttributeCheckbox;
use common\models\object\GroupCheckbox;
use common\models\object\ObjectAttributeCheckbox;
use common\models\object\AttributeRadio;
use common\models\object\GroupRadio;
use common\models\object\ObjectAttributeRadio;

/**
 * ObjectController implements the CRUD actions for Object model.
 */
class ObjectController extends DefaultBackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['can_create_object'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Object models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Object model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $imgs = ObjectImg::find()->where(['object_id' => $id])->all();

        $files = ObjectFile::find()->where(['object_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'imgs' => $imgs,
            'files' => $files
        ]);
    }

    /**
     * Creates a new Object model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Object();
        $values = $this->initValues($model);

        $listCheckbox = AttributeCheckbox::find()->joinWith('groupCheckboxes')->all();
        $rezCheckbox = [];

        /* Radio/ */
        $listRadio = AttributeRadio::find()->joinWith('groupRadios')->all();
        $rezRadio = [];
        /* /Radio */

        $model->attributes['created_at'] = time();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save() &&  Model::loadMultiple($values, $post)) {
            $this->processValues($values, $model);

            $this->saveCheckbox(Yii::$app->request->post('GroupCheckboxes')[$model->type_id], $model);

            /* Radio/ */
            $this->saveRadio(Yii::$app->request->post('GroupRadios')[$model->type_id], $model);
            /* /Radio */

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'values' => $values,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio

        ]);
    }

    /**
     * Updates an existing Object model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $values = $this->initValues($model);

        $listCheckbox = AttributeCheckbox::find()->joinWith('groupCheckboxes')->all();
        $modelCheckbox = ObjectAttributeCheckbox::find()->where(['object_id' => $id])->all();
        $rezCheckbox = [];
        foreach ($modelCheckbox as $item){
            $rezCheckbox[] .= $item->group_id;
        }

        /* Radio/ */
        $listRadio = AttributeRadio::find()->joinWith('groupRadios')->all();
        $modelRadio = ObjectAttributeRadio::find()->where(['object_id' => $id])->all();
        $rezRadio = [];
        foreach ($modelRadio as $item){
            $rezRadio[] .= $item->group_id;
        }
        /* /Radio */

        $post = Yii::$app->request->post();
        $addFile = new ObjectFile();

        /* загрузка файла */
        if ($post['ObjectFile'] && $_FILES['ObjectFile']){

            $dir = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $id .'/';

            if (!is_dir($dir)){
                FileHelper::createDirectory($dir);
            }

            $addFile->docFile = UploadedFile::getInstance($addFile, 'doc');

            $docName = strtotime('now') . '_' . Yii::$app->security->generateRandomString(8) . '.' . $addFile->docFile->getExtension();

            $addFile->object_id = $id;
            $addFile->title = $post['ObjectFile']['title'];
            $addFile->doc = '/uploads/objects/doc/' . $id .'/' . $docName;

            $addFile->docFile->saveAs($dir . $docName);

            if($addFile->validate() && $addFile->save()) {
                //return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        /* удаление файла pjax */
        $get = Yii::$app->request->get();
        if(Yii::$app->request->isAjax && $get['file_id'] &&  !$_FILES['ObjectFile']){
            $delFile = ObjectFile::findOne($get['file_id']);
            $delFile->delete();
        }

        $listFiles = ObjectFile::find()->where(['object_id' => $id])->all();

        if ($model->load($post) && $model->updateDate() && $model->save() &&  Model::loadMultiple($values, $post)) {
            $this->processValues($values, $model);

            $this->saveCheckbox(Yii::$app->request->post('GroupCheckboxes')[$model->type_id], $model);

            /* Radio/ */
            $this->saveRadio(Yii::$app->request->post('GroupRadios')[$model->type_id], $model);
            /* /Radio */

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'values' => $values,
            'addFile' => $addFile,
            'listFiles' => $listFiles,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio
        ]);
    }

    /**
     * Deletes an existing Object model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Object model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Object the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Object::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function initValues(Object $model){
        $values = $model->getObjectAttributes()->indexBy('attribute_id')->all();
        $attributes = Attribute::find()->indexBy('id')->all();

        foreach (array_diff_key($attributes, $values) as $attribute) {
            $values[$attribute->id] = new ObjectAttribute(['attribute_id' => $attribute->id]);
        }

       /*foreach ($values as $value) {
            $value->setScenario(ObjectAttribute::SCENARIO_TABULAR);
        }*/

        return $values;
    }

    private function processValues($values, Object $model)
    {
        foreach ($values as $value) {
            $value->object_id = $model->id;

            $objectAttrinute = ObjectAttribute::find()
                                    ->where(['object_id' => $model->id])
                                    ->andWhere(['attribute_id' => $value->attribute_id])
                                    ->one();

            $checkAttr = Attribute::findOne($value->attribute_id);
            if ($model->type_id == $checkAttr->type_id) {
                if ($objectAttrinute) {
                    if ($value->value === '') {
                        $objectAttrinute->delete(['object_id' => $model->id, 'attribute_id' => $value->attribute_id]);
                    } else {
                        $objectAttrinute->value = $value->value;
                        $objectAttrinute->save();
                    }
                } else {
                    if (str_replace(' ', '', $value->value)) {
                        $value->save(false);
                    }
                }
            }else{
                if($objectAttrinute){
                    $objectAttrinute->delete(['object_id' => $model->id, 'attribute_id' => $value->attribute_id]);
                }
            }
        }
    }

    /**
     * Сохраниение checkbox
     */
    private function saveCheckbox($groups, $model){

        $listModel = ObjectAttributeCheckbox::find()->where(['object_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item){
            $arrListGroups[] .= $item->group_id;
        }

        $delArr = [];
        if ($groups){
            foreach ($groups as $id => $group){
                foreach ($group as $item){
                    if (!in_array($item, $arrListGroups)){
                        $addNewAttr = new ObjectAttributeCheckbox();
                        $addNewAttr->object_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }else{
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item,$arrListGroups)]);
                    }

                    /*$checkGroup = ObjectAttributeCheckbox::find()
                        ->where(['object_id' => $model->id])
                        ->andWhere(['attribute_id' => $id])
                        ->andWhere(['group_id' => $item])
                        ->one();
                    if (!$checkGroup){
                        $addNewAttr = new ObjectAttributeCheckbox();
                        $addNewAttr->object_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }*/

                }

            }
        }


        foreach ($arrListGroups as $arrListGroup) {
            $delModel = ObjectAttributeCheckbox::find()
                ->where(['object_id' => $model->id])
                ->andWhere(['group_id' => $arrListGroup])
                ->one();
            //$delModel1 = ObjectAttributeCheckbox::findOne(18);
            if ($delModel) {
                $delModel->delete(['object_id' => $model->id, 'group_id' => $arrListGroup]);
            }
        }


        /*foreach ($arrListGroups as $arrListGroup) {
            if (!in_array($arrListGroup, $delArr)) {
                $delModel = ObjectAttributeCheckbox::find()
                    ->where(['object_id' => $model->id])
                    ->andWhere(['group_id' => $arrListGroup])
                    ->one();*/
                /*if ($delModel) {
                    $delModel->delete();
                }*/
            /*}
        }*/

    }

    /**
     * Сохраниение radio
     */
    private function saveRadio($groups, $model){

        $listModel = ObjectAttributeRadio::find()->where(['object_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item){
            $arrListGroups[] .= $item->group_id;
        }

        $delArr = [];
        if ($groups){
            foreach ($groups as $id => $group){
                foreach ($group as $item){
                    if (!in_array($item, $arrListGroups)){
                        $addNewAttr = new ObjectAttributeRadio();
                        $addNewAttr->object_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }else{
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item,$arrListGroups)]);
                    }

                    /*$checkGroup = ObjectAttributeCheckbox::find()
                        ->where(['object_id' => $model->id])
                        ->andWhere(['attribute_id' => $id])
                        ->andWhere(['group_id' => $item])
                        ->one();
                    if (!$checkGroup){
                        $addNewAttr = new ObjectAttributeCheckbox();
                        $addNewAttr->object_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if($addNewAttr->validate()){
                            $addNewAttr->save();
                        }
                    }*/

                }

            }
        }


        foreach ($arrListGroups as $arrListGroup) {
            $delModel = ObjectAttributeRadio::find()
                ->where(['object_id' => $model->id])
                ->andWhere(['group_id' => $arrListGroup])
                ->one();
            //$delModel1 = ObjectAttributeRadio::findOne(18);
            if ($delModel) {
                $delModel->delete(['object_id' => $model->id, 'group_id' => $arrListGroup]);
            }
        }


        /*foreach ($arrListGroups as $arrListGroup) {
            if (!in_array($arrListGroup, $delArr)) {
                $delModel = ObjectAttributeCheckbox::find()
                    ->where(['object_id' => $model->id])
                    ->andWhere(['group_id' => $arrListGroup])
                    ->one();*/
        /*if ($delModel) {
            $delModel->delete();
        }*/
        /*}
    }*/

    }

    /**
     * Загрузка фото
     */
    public function actionSaveImg(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@frontend') . '/web/uploads/objects/img/' . $post['object_id'] .'/';

            if (!is_dir($dir)){
                FileHelper::createDirectory($dir);
            }

            $result_link = str_replace('admin', '', Url::home(true) . 'uploads/object/img/' . $post['object_id'] .'/');
            $file = UploadedFile::getInstancesByName( 'imgFile');
            $file = array_shift($file);

            if (is_null($file)){
                return 'Файлы уже загруженны';
            }

            $imgName = strtotime('now') . '_' . Yii::$app->security->generateRandomString(8). '.' . $file->getExtension();

            $fullName = $dir . $imgName;

            $model = new ObjectImg();
            $model->object_id = $post['object_id'];
            $model->img = 'uploads/objects/img/' . $post['object_id'] .'/' . $imgName;

            if ($model->validate()){
                if($file->saveAs($fullName)){
                    if($model->save()){
                        $resilt = [
                            'filelink' => $result_link . $fullName
                        ];
                    };
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $resilt;
        }
    }
    public function actionDeleteImg(){
        if($model = ObjectImg::findOne(Yii::$app->request->post('key'))){

            //$dir = Yii::getAlias('@frontend') . '/web/' . $model->img;

            if($model->delete()){
                return true;
            }else{
                throw new NotFoundHttpException('Изображение уже было удаленно');
            }
        }
    }
    public function actionSortImg($id){
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post('sort');
            if($post['oldIndex'] > $post['newIndex']){
                $param = ['and', ['>=', 'sort', $post['newIndex']],['<', 'sort', $post['oldIndex']]];
                $conter = 1;
            }else{
                $param = ['and', ['<=', 'sort', $post['newIndex']],['>', 'sort', $post['oldIndex']]];
                $conter = -1;
            }
            ObjectImg::updateAllCounters(
                ['sort' =>$conter], ['and', ['object_id' => $id], $param]
            );
            ObjectImg::updateAll(
                ['sort' =>$post['newIndex']], ['id' => $post['stack'][$post['newIndex']]['key']]
            );
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }


    public function actionPjax()
    {
        return $this->redirect(['update', 'id' => 2]);
    }


}
