<?php

namespace backend\controllers;

use backend\modules\rbac\models\AuthAssignment;
use backend\modules\rbac\models\AuthItem;
use common\helpers\ImageHelper;
use common\models\object\Confidence;
use common\models\object\ConfidenceObject;
use common\models\object\LocalityType;
use common\models\object\ObjectConfidence;
use common\models\object\ObjectConfidenceFile;
use common\models\User;
use common\models\UserModel;
use Yii;
use common\models\object\Object;
use backend\models\ObjectSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
use yii\data\ActiveDataProvider;
use common\models\RoomObjectUser;

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
            'title' => 'Каталог объектов'
        ]);
    }

    public function actionObjectModeration()
    {
        $searchModel = new ObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['or', ['object.status' => 0], ['object.status' => null]]);
        if (!Yii::$app->user->can('access_moderate_users_object')) {
            $dataProvider->query->andWhere(['broker_id' => Yii::$app->user->id]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Объекты на модерации'
        ]);
    }

    public function actions()
    {
        return [
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => Object::find(),
            ],
        ];
    }

    /**
     * Displays a single Object model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $imgs = ObjectImg::find()->where(['object_id' => $id])->all();

        $files = ObjectFile::find()->where(['object_id' => $id])->all();

        /* доверие объекту */
        $confObj = $this->confObj($id);

        /* шкала */
        $chekRoomUser = RoomObjectUser::find()->where(['object_id' => $id])->andWhere(['active' => 1])->all();
        if (isset($chekRoomUser)) {
            $sumAmount = 0;
            foreach ($chekRoomUser as $item) {
                $sumAmount = $sumAmount + $item->sum;
            }
            $progress['print-amount'] = $sumAmount;

            if ($sumAmount == 0) {
                $progress['amount-percent'] = 0;
            } else {
                if ((int)$model->amount > $sumAmount) {
                    $progress['amount-percent'] = number_format($sumAmount / ((int)$model->amount / 100), 2, '.', ' ');
                } else {
                    $progress['amount-percent'] = 100;
                }
            }

        } else {
            $progress['print-amount'] = 0;
            $progress['amount-percent'] = 0;
        }

        $usersObjectlist = new ActiveDataProvider([
            'query' => RoomObjectUser::find()
                ->where(['object_id' => $id])
                ->joinWith('user')
                ->joinWith('userAvatar'),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        if ($model->status_object == 0) {
            $finishObject = false;
        } else {
            $finishObject = true;
        }

        $cityLocalityTypeId = LocalityType::find()->where(['name' => 'Город'])->one();

        $confidences = ArrayHelper::map(Confidence::find()->all(), 'id', 'title');
        $objectConfidences = $model->getObjectConfidence()->indexBy('confidence_id')->all();
        $objectConfidencesFiles = [];
        if (!empty($objectConfidences)) {
            foreach ($objectConfidences as $confidence) {
                $file = $confidence->getFile();
                if (isset($file)) {
                    $objectConfidencesFiles[$confidence->confidence_id] = $file;
                }
            }
        }

        return $this->render('view', [
            'model' => $model,
            'imgs' => $imgs,
            'files' => $files,
            'usersObjectlist' => $usersObjectlist,
            'finishObject' => $finishObject,
            'progress' => $progress,
            'confObj' => $confObj,
            'cityLocalityTypeId' => $cityLocalityTypeId,
            'objectConfidences' => $objectConfidences,
            'objectConfidencesFiles' => $objectConfidencesFiles,
            'confidences' => $confidences
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

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $role = AuthAssignment::find()->where(['user_id' => Yii::$app->user->id])->one();
            if (!isset($model->broker_id) && isset($role) && $role->item_name == 'broker') {
                $model->broker_id = Yii::$app->user->id;
            }
            if ($model->save() && Model::loadMultiple($values, $post)) {

                $this->processValues($values, $model);

                $this->saveCheckbox(Yii::$app->request->post('GroupCheckboxes')[$model->type_id], $model);

                /* Radio/ */
                $this->saveRadio(Yii::$app->request->post('GroupRadios')[$model->type_id], $model);
                /* /Radio */

                return $this->redirect(['create-img', 'id' => $model->id]);
            }
        }
        $listCheckbox = AttributeCheckbox::find()->joinWith('groupCheckboxes')->all();
        $groupCheckboxes = Yii::$app->request->post('GroupCheckboxes');
        $rezCheckbox = [];
        if (!empty($groupCheckboxes)) {
            foreach ($groupCheckboxes as $checkboxGroup) {
                foreach ($checkboxGroup as $checkboxArr) {
                    $rezCheckbox = ArrayHelper::merge($rezCheckbox, $checkboxArr);
                }
            }
        }

        /* Radio/ */
        $listRadio = AttributeRadio::find()->joinWith('groupRadios')->all();
        $groupRadios = Yii::$app->request->post('GroupRadios');
        $rezRadio = [];
        if (!empty($groupRadios)) {
            foreach ($groupRadios as $radioGroup) {
                foreach ($radioGroup as $radioArr) {
                    $rezRadio = ArrayHelper::merge($rezRadio, $radioArr);
                }
            }
        }
        /* /Radio */

        $regionCollection = \common\models\object\Region::find()->all();
        $region = ArrayHelper::map($regionCollection, 'id', 'name');

        $cities = [];

        $localityTypeCollection = LocalityType::find()->all();
        $localityType = ArrayHelper::map($localityTypeCollection, 'id', 'name');

        $userIds = ArrayHelper::getColumn(AuthAssignment::find()->where(['item_name' => 'broker'])->all(), 'user_id');
        $brokersCollection = User::find()->where(['in', 'id', $userIds])->all();
//        var_dump(Yii::$app->request->post());die;
        return $this->render('create', [
            'model' => $model,
            'values' => $values,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio,
            'region' => $region,
            'cities' => $cities,
            'localityType' => $localityType,
            'brokersCollection' => $brokersCollection
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
        foreach ($modelCheckbox as $item) {
            $rezCheckbox[] .= $item->group_id;
        }

        /* Radio/ */
        $listRadio = AttributeRadio::find()->joinWith('groupRadios')->all();
        $modelRadio = ObjectAttributeRadio::find()->where(['object_id' => $id])->all();
        $rezRadio = [];
        foreach ($modelRadio as $item) {
            $rezRadio[] .= $item->group_id;
        }
        /* /Radio */

        $post = Yii::$app->request->post();
        $addFile = new ObjectFile();

        /* загрузка файла */
        if ($post['ObjectFile'] ?? $_FILES['ObjectFile'] ?? false) {
            $this->addFile($addFile, $id, $post);
        }

        /* удаление файла pjax */
        $get = Yii::$app->request->get();
        if (Yii::$app->request->isAjax && isset($get['file_id']) && !isset($_FILES['ObjectFile'])) {
            $this->delFile((int)$get['file_id']);
        }

        /* загрузка файла справки*/

        $confidences = ArrayHelper::map(Confidence::find()->all(), 'id', 'title');
        $confidenceFilesUploaded = true;
        if (!empty($_FILES)) {
            $confidenceFilesUploaded = $this->addConfidenceFiles($confidences, $model, $post);
        }

        /* удаление файла справки pjax */
        $get = Yii::$app->request->get();
        if (Yii::$app->request->isAjax && isset($get['file_id']) && !isset($_FILES['ObjectConfidenceFile'])) {
            $this->delConfidenceFile((int)$get['file_id'], (int)$get['id'], (int)$get['confidence_id']);
        }

        $listFiles = ObjectFile::find()->where(['object_id' => $id])->all();

        $objectConf = $this->updateConfidences($post);
        if (!$objectConf['errors']) {
            $objectConfidences = ObjectConfidence::find()->where(['object_id' => $id])->indexBy('confidence_id')->all();
        } else {
            $objectConfidences = $objectConf['objectConfidences'];
        }
        if ($model->load($post) && $model->updateDate() && $model->save() && Model::loadMultiple($values, $post) && !$objectConf['errors'] && $confidenceFilesUploaded) {
            $this->processValues($values, $model);

            $this->saveCheckbox(Yii::$app->request->post('GroupCheckboxes')[$model->type_id], $model);

            /* Radio/ */
            $this->saveRadio(Yii::$app->request->post('GroupRadios')[$model->type_id], $model);
            /* /Radio */

            return $this->redirect(['view', 'id' => $model->id]);
        }


        $regionCollection = \common\models\object\Region::find()->all();
        $region = ArrayHelper::map($regionCollection, 'id', 'name');

        $cities = [];

        $localityTypeCollection = LocalityType::find()->all();
        $localityType = ArrayHelper::map($localityTypeCollection, 'id', 'name');

        $userIds = ArrayHelper::getColumn(AuthAssignment::find()->where(['item_name' => 'broker'])->all(), 'user_id');
        $brokersCollection = User::find()->where(['in', 'id', $userIds])->all();
        $confidenceAddFiles = [];
        $confidenceFilesList = [];
        foreach ($confidences as $id => $val) {
            $confidenceAddFiles[$id] = new ObjectConfidenceFile();
            $confidenceAddFiles[$id]->confidence_id = $id;
            $confidenceAddFiles[$id]->object_id = $model->id;
            $file = isset($objectConfidences[$id]) ? $objectConfidences[$id]->getFile() : null;
            if (isset($file)) {
                $confidenceFilesList[$id] = $file;
            }
        }
        return $this->render('update', [
            'model' => $model,
            'values' => $values,
            'addFile' => $addFile,
            'listFiles' => $listFiles,
            'listCheckbox' => $listCheckbox,
            'rezCheckbox' => $rezCheckbox,
            'listRadio' => $listRadio,
            'rezRadio' => $rezRadio,
            'region' => $region,
            'cities' => $cities,
            'localityType' => $localityType,
            'brokersCollection' => $brokersCollection,
            'objectConfidences' => $objectConfidences,
            'confidences' => $confidences,
            'confidenceAddFiles' => $confidenceAddFiles,
            'confidenceFilesList' => $confidenceFilesList
        ]);
    }

    public function actionCreateImg($id)
    {
        $model = $this->findModel($id);
        return $this->render('create-img', [
            'model' => $model,
        ]);
    }

    public function actionCreateFile($id)
    {
        $post = Yii::$app->request->post();
        $addFile = new ObjectFile();

        /* загрузка файла */
        if ($post['ObjectFile'] ?? $_FILES['ObjectFile'] ?? false) {
            $this->addFile($addFile, $id, $post);
        }

        /* удаление файла pjax */
        $get = Yii::$app->request->get();
        if (Yii::$app->request->isAjax && isset($get['file_id']) && !isset($_FILES['ObjectFile'])) {
            $this->delFile((int)$get['file_id']);
        }

        $listFiles = ObjectFile::find()->where(['object_id' => $id])->all();

        return $this->render('create-file', [
            'addFile' => $addFile,
            'listFiles' => $listFiles,
            'objectId' => $id
        ]);
    }

    public function actionClose($id)
    {
        $model = $this->findModel($id);
        $model->status_object = 0;
        $model->update();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionOpen($id)
    {
        $model = $this->findModel($id);
        $model->status_object = 2;
        $model->update();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Object::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function addFile($addFile, $id, $post)
    {

        $dir = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $id . '/';

        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir);
        }

        $addFile->docFile = UploadedFile::getInstances($addFile, 'doc');

        foreach ($addFile->docFile as $file) {
            $addFile = new ObjectFile();

            $fileTitle = mb_substr($file->name, 0, -mb_strlen(strrchr($file->name, '.')));

            $docName = strtotime('now') . '_' . Yii::$app->security->generateRandomString(8) . '.' . substr(strrchr($file->name, '.'), 1);;

            $addFile->object_id = $id;
            $addFile->title = $fileTitle;
            $addFile->doc = '/uploads/objects/doc/' . $id . '/' . $docName;

            if ($file->saveAs($dir . $docName)) {
                if ($addFile->validate()) {
                    $addFile->save();
                }
            };
        }
    }

    private function addConfidenceFiles($confidences, $model)
    {
        $dir = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $model->id . '/conf/';

        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir);
        }
        $fileNames = [];
        foreach ($confidences as $confId => $title) {
            $fileName = 'ObjectConfidence_' . $model->id . '_' . $confId . '_file';
            $fileNames[] = $fileName;
            if (key_exists($fileName, $_FILES)) {
                $file = UploadedFile::getInstanceByName($fileName);
                if (!empty($file)) {
                    $fileTitle = mb_substr($file->name, 0, -mb_strlen(strrchr($file->name, '.')));
                    $docName = strtotime('now') . '_' . Yii::$app->security->generateRandomString(8) . '.' . substr(strrchr($file->name, '.'), 1);;
                    $addFile = new ObjectConfidenceFile();
                    $addFile->confidence_id = $confId;
                    $addFile->object_id = $model->id;
                    $addFile->title = $fileTitle;
                    $addFile->doc = '/uploads/objects/doc/' . $model->id . '/conf/' . $docName;
                    if (!$file->saveAs($dir . $docName)) {
                        return false;
                    };
                    if (!$addFile->validate()) {
                        return false;
                    }
                    if (!$addFile->save()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    private function delFile($fileId)
    {
        $delFile = ObjectFile::findOne($fileId);
        if (isset($delFile)) {
            $delFile->delete();
        }
    }

    private function delConfidenceFile($fileId, $objectId, $confidenceId)
    {
        $delFile = ObjectConfidenceFile::findOne($fileId);
        if (isset($delFile)) {
            $delFile->object_id = $objectId;
            $delFile->confidence_id = $confidenceId;
            $delFile->delete();
        }
    }

    private function initValues(Object $model)
    {
        $postValues =  Yii::$app->request->post('ObjectAttribute');
        $values = $model->getObjectAttributes()->indexBy('attribute_id')->all();
        $attributes = Attribute::find()->indexBy('id')->all();

        foreach (array_diff_key($attributes, $values) as $attribute) {
            $values[$attribute->id] = new ObjectAttribute(['attribute_id' => $attribute->id]);
            if (!empty($postValues) && is_null($values[$attribute->id]->value) && isset($postValues[$attribute->id]['value'])) {
                $values[$attribute->id]->value = $postValues[$attribute->id]['value'];
            }
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
            } else {
                if ($objectAttrinute) {
                    $objectAttrinute->delete(['object_id' => $model->id, 'attribute_id' => $value->attribute_id]);
                }
            }
        }
    }

    /**
     * Сохраниение checkbox
     */
    private function saveCheckbox($groups, $model)
    {

        $listModel = ObjectAttributeCheckbox::find()->where(['object_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item) {
            $arrListGroups[] .= $item->group_id;
        }

        $delArr = [];
        if ($groups) {
            foreach ($groups as $id => $group) {
                foreach ($group as $item) {
                    if (!in_array($item, $arrListGroups)) {
                        $addNewAttr = new ObjectAttributeCheckbox();
                        $addNewAttr->object_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if ($addNewAttr->validate()) {
                            $addNewAttr->save();
                        }
                    } else {
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item, $arrListGroups)]);
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
    private function saveRadio($groups, $model)
    {

        $listModel = ObjectAttributeRadio::find()->where(['object_id' => $model->id])->all();

        $arrListGroups = [];
        foreach ($listModel as $item) {
            $arrListGroups[] .= $item->group_id;
        }

        $delArr = [];
        if ($groups) {
            foreach ($groups as $id => $group) {
                foreach ($group as $item) {
                    if (!in_array($item, $arrListGroups)) {
                        $addNewAttr = new ObjectAttributeRadio();
                        $addNewAttr->object_id = $model->id;
                        $addNewAttr->attribute_id = $id;
                        $addNewAttr->group_id = $item;
                        if ($addNewAttr->validate()) {
                            $addNewAttr->save();
                        }
                    } else {
                        $delArr[] .= $item;
                        unset($arrListGroups[array_search($item, $arrListGroups)]);
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
    public function actionSaveImg()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@frontend') . '/web/uploads/objects/img/' . $post['object_id'] . '/';

            if (!is_dir($dir)) {
                FileHelper::createDirectory($dir);
            }

            $result_link = str_replace('admin', '', Url::home(true) . 'uploads/object/img/' . $post['object_id'] . '/');
            $file = UploadedFile::getInstancesByName('imgFile');
            $file = array_shift($file);

            if (is_null($file)) {
                return 'Файлы уже загруженны';
            }
            $secret = Yii::$app->security->generateRandomString(8);
            $imgName = strtotime('now') . '_' . $secret . '.' . $file->getExtension();
            $imgMinName = strtotime('now') . '_' . $secret . '_min.' . $file->getExtension();

            $fullName = $dir . $imgName;
            $fullMinName = $dir . $imgMinName;

            $model = new ObjectImg();
            $model->object_id = $post['object_id'];
            $model->img = '/uploads/objects/img/' . $post['object_id'] . '/' . $imgName;
            $model->img_min = '/uploads/objects/img/' . $post['object_id'] . '/' . $imgMinName;

            if ($model->validate()) {
                if ($file->saveAs($fullName, false)) {
                    if (!ImageHelper::crop(670, 375, $file->tempName, $fullMinName)) {
                        $model->img_min = null;
                    }

                    if ($model->save()) {
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

    public function actionDeleteImg()
    {
        if ($model = ObjectImg::findOne(Yii::$app->request->post('key'))) {

            //$dir = Yii::getAlias('@frontend') . '/web/' . $model->img;

            if ($model->delete()) {
                return true;
            } else {
                throw new NotFoundHttpException('Изображение уже было удаленно');
            }
        } else {
            throw new NotFoundHttpException('изображение не найдено');
        }
    }

    public function actionSortImg($id)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $conter = 1;
            } else {
                $param = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $conter = -1;
            }
            ObjectImg::updateAllCounters(
                ['sort' => $conter], ['and', ['object_id' => $id], $param]
            );
            ObjectImg::updateAll(
                ['sort' => $post['newIndex']], ['id' => $post['stack'][$post['newIndex']]['key']]
            );
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }


    public function actionPjax()
    {
        return $this->redirect(['update', 'id' => 2]);
    }

    /* отдать объект инвестору */
    public function actionObjectFinish($oId, $uId)
    {
        if (isset($oId) && isset($uId)) {
            $modelObjUser = RoomObjectUser::find()
                ->where(['object_id' => $oId])
                ->andWhere(['user_id' => $uId])
                ->one();
            if (isset($modelObjUser)) {
                $modelObjUser->active = 1;
                $modelObjUser->update();

                $object = Object::find()->where(['id' => $oId])->one();
                $user = UserModel::find()->where(['id' => $uId])->one();
                Yii::$app->email->acceptSubscribeObject($user->email, $object->title);
                /* проверяем всю собранную сумме, если она подходит, то изменяем статус у объекта на "закрыт" */
                $object = Object::findOne($oId);
                $modelObjUsers = RoomObjectUser::find()
                    ->where(['object_id' => $oId])
                    ->andWhere(['active' => 1])
                    ->all();
                if (isset($modelObjUsers)) {
                    $sum = 0;
                    foreach ($modelObjUsers as $item) {
                        $sum = $sum + $item->sum;
                    }
                }
            }
            return $this->redirect(['view', 'id' => $oId]);
        } else {
            throw new NotFoundHttpException('Вы передали не все параметры');
        }
    }

    /* забрать объект у инвестора */
    public function actionObjectFinishBack($oId, $uId)
    {
        if (isset($oId) && isset($uId)) {
            $modelObjUser = RoomObjectUser::find()
                ->where(['object_id' => $oId])
                ->andWhere(['user_id' => $uId])
                ->one();
            if (isset($modelObjUser)) {
                $modelObjUser->active = 0;
                $modelObjUser->update();
                $object = Object::find()->where(['id' => $oId])->one();
                $user = UserModel::find()->where(['id' => Yii::$app->user->id])->one();
                Yii::$app->email->takeAwayObject($user->email, $object->title);
            }
            return $this->redirect(['view', 'id' => $oId]);
        } else {
            throw new NotFoundHttpException('Вы передали не все параметры');
        }
    }

    /* отписаться */
    public function actionUnsubscribe($oId, $uId)
    {
        if (isset($oId) && isset($uId)) {
            $this->unsubscribeAll($oId, $uId);
            $object = Object::find()->where(['id' => $oId])->one();
            $user = UserModel::find()->where(['id' => Yii::$app->user->id])->one();
            Yii::$app->email->unsubscribeObject($user->email, $object->title);
        } else {
            throw new NotFoundHttpException('Вы передали не все параметры');
        }
    }

    private function unsubscribeAll($oId, $uId)
    {
        $userList = RoomObjectUser::find()
            ->where(['object_id' => $oId])
            ->andWhere(['user_id' => $uId])
            ->one();

        if ($userList) {
            $userList->delete(['object_id' => $oId, 'user_id' => Yii::$app->user->id]);
        }

        $checkRoomObjects = RoomObjectUser::find()
            ->where(['object_id' => $oId])
            ->all();

        $object = Object::findOne($oId);
        if (!$checkRoomObjects) {
            $object->status_object = 2;
        } else {
            $object->status_object = 1;
        }

        $object->save();

        return $this->redirect(['view', 'id' => $oId]);

    }

    /* доверие объекту */
    private function confObj($obId)
    {
        $allListConf = count(Confidence::find()->all());
        $listConf = count(ConfidenceObject::find()->where(['object_id' => $obId])->all());
        return round($listConf * 100 / $allListConf, 2);
    }

    public function actionGetCities($id)
    {
        $citiesCollection = \common\models\object\City::find()->where(['region_id' => $id])->all();
        $cities = ArrayHelper::map($citiesCollection, 'id', 'name');
        $mKad = ArrayHelper::map($citiesCollection, 'id', 'mkad');
        $mkadParams = [];
        if (!empty($mKad)) {
            foreach ($mKad as $id => $val) {
                $mkadParams[$id]['data-mkad'] = $val;
            }
        }
        $options = ['options' => $mkadParams];
        return Html::renderSelectOptions(null, $cities, $options);
    }

    public function actionCreateConfidence($id)
    {
        /**
         * TODO: refactor this s*t.
         * Id string pattern: ObjectConfidence_{$object_id}_{confidence_id}_*field-name*
         */
        $object = Object::find()->where(['id' => $id])->one();
        $confidences = ArrayHelper::map(Confidence::find()->all(), 'id', 'title');
        $confidenceFilesUploaded = true;
        if (!empty($_FILES)) {
            $confidenceFilesUploaded = $this->addConfidenceFiles($confidences, $object);
        }
        if ($post = Yii::$app->request->post()) {
            $objectConf = $this->updateConfidences($post);
            if (!$objectConf['errors'] && $confidenceFilesUploaded) {
                return $this->redirect(['view', 'id' => $id]);
            }
            $objectConfidences = $objectConf['objectConfidences'];
        } else {
            $objectConfidences = ObjectConfidence::find()->where(['object_id' => $id])->indexBy('confidence_id')->all();
        }
        $confidenceAddFiles = [];
        $confidenceFilesList = [];
        foreach ($confidences as $id => $val) {
            $confidenceAddFiles[$id] = new ObjectConfidenceFile();
            $confidenceAddFiles[$id]->confidence_id = $id;
            $confidenceAddFiles[$id]->object_id = $object->id;
            $file = isset($objectConfidences[$id]) ? $objectConfidences[$id]->getFile() : null;
            if (isset($file)) {
                $confidenceFilesList[$id] = $file;
            }
        }
        return $this->render('create-confidence', [
            'model' => $object,
            'objectConfidences' => $objectConfidences,
            'confidences' => $confidences,
            'confidenceAddFiles' => $confidenceAddFiles,
            'confidenceFilesList' => $confidenceFilesList
        ]);
    }

    private function updateConfidences($post)
    {
        $errors = false;
        $objectConfidences = [];
        if ($post) {
            $objectConfidenceData = [];
            foreach ($post as $postId => $value) {
                if (strpos($postId, 'ObjectConfidence_') !== false) {
                    list($objectName, $objectId, $confidenceId, $fieldName) = explode('_', $postId);
                    if (!key_exists($confidenceId, $objectConfidenceData)) {
                        $objectConfidenceData[$confidenceId] = [
                            'object_id' => $objectId,
                            'confidence_id' => $confidenceId,
                            'check' => false,
                        ];
                    }
                    $objectConfidenceData[$confidenceId][$fieldName] = $value;
                }
            }
            ksort($objectConfidenceData);
            foreach ($objectConfidenceData as $confidenceData) {
                $confidence = ObjectConfidence::find()->where(['object_id' => $confidenceData['object_id'], 'confidence_id' => $confidenceData['confidence_id']])->one();
                $params = ['ObjectConfidence' => $confidenceData];
                if ($confidence->load($params) && $confidence->validate()) {
                    $confidence->save();
                }
                if (!empty($confidence->getErrors())) {
                    $errors = true;
                }
                $objectConfidences[$confidence->confidence_id] = $confidence;
            }
        }
        return ['objectConfidences' => $objectConfidences, 'errors' => $errors];
    }
}
