<?php

namespace frontend\controllers;

use common\models\CommentObject;
use common\models\object\AttributeCheckbox;
use common\models\object\GroupCheckbox;
use common\models\object\ObjectAttributeCheckbox;
use common\models\object\ObjectFile;
use common\models\object\ObjectImg;
use common\models\passport\UserPassport;
use common\models\RoomObjectUser;
use common\models\UserModel;
use Victor78\Zipper\Zipper;
use Yii;
use common\models\object\Object;
use frontend\models\ObjectSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use frontend\components\controllers\DefaultFrontendController;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\object\AttributeRadio;
use common\models\object\Attribute;
use common\models\object\Confidence;
use common\models\object\ConfidenceObject;
use yii\web\Request;

class CatalogController extends DefaultFrontendController
{

    public $layout = "user_layout";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user', 'admin']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['payment/pay']);
                }
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user = UserModel::findOne(Yii::$app->user->id);

        /* min и max фильтр */
        $filter = $this->filter();

        $filterPassport = UserPassport::find()
            ->where(['id' => $user->user_passport_id])
            ->joinWith('checkboxs')
            ->joinWith('radios')
            ->one();

        $arrFilterPassport = [];
        foreach ($filterPassport->checkboxs as $item) {
            if (isset($arrFilterPassport['checkboxs'][$item->attribute_id])) {
                array_push($arrFilterPassport['checkboxs'][$item->attribute_id], $item->group_id);
            } else {
                $arrFilterPassport['checkboxs'][$item->attribute_id] = [$item->group_id];
            }
        }

        foreach ($filterPassport->radios as $item) {
            if (isset($arrFilterPassport['radios'][$item->attribute_id])) {
                array_push($arrFilterPassport['radios'][$item->attribute_id], $item->group_id);
            } else {
                $arrFilterPassport['radios'][$item->attribute_id] = [$item->group_id];
            }
        }


        if (isset($_GET['ObjectSearch']['type_id'])) {
            $type_id = $_GET['ObjectSearch']['type_id'];
        }

        $listValues = Attribute::find()->all();
        $rezValues = [];
        if (isset($type_id)) {
            if (isset($_GET['GroupValues'][$type_id])) {
                foreach ($_GET['GroupValues'][$type_id] as $items) {
                    foreach ($items as $item) {
                        $rezValues[] = $item;
                    }
                }
            }
        }

        $listCheckboxes = AttributeCheckbox::find()->joinWith('groupCheckboxes')->all();
        $rezCheckboxes = [];
        if (isset($type_id)) {
            if (isset($_GET['GroupCheckboxes'][$type_id])) {
                foreach ($_GET['GroupCheckboxes'][$type_id] as $items) {
                    foreach ($items as $item) {
                        $rezCheckboxes[] = $item;
                    }
                }
            }
        }

        $listRadios = AttributeRadio::find()->joinWith('groupRadios')->all();
        $rezRadios = [];
        if (isset($type_id)) {
            if (isset($_GET['GroupRadios'][$type_id])) {
                foreach ($_GET['GroupRadios'][$type_id] as $items) {
                    foreach ($items as $item) {
                        $rezRadios[] = $item;
                    }
                }
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'listValues' => $listValues,
            'listCheckboxes' => $listCheckboxes,
            'listRadios' => $listRadios,
            'rezCheckboxes' => $rezCheckboxes,
            'rezRadios' => $rezRadios,
            'filter' => $filter,
            'filterPassport' => $filterPassport,
            'arrFilterPassport' => $arrFilterPassport
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $commentNew = new CommentObject();

        $userRoom = new RoomObjectUser();
        $userRoom->sum = (int)$model->amount;
        $userRoom->rate = $model->rate;
        $userRoom->term = $model->term;
        $userRoom->schedule_payments = $model->schedule_payments;
        $userRoom->nks = $model->nks;

        /* доверие объекту */
        /** TODO: заменяем старое доверие к объекту */

        $objectRates = (int) $model->getObjectConfidence()->sum('rate');
        $confObj = round($objectRates);
//        $confObj = $this->confObj($id);

        $modelImgs = ObjectImg::find()->where(['object_id' => $id])->orderBy('sort ASC')->all();
        $modelFiles = ObjectFile::find()->where(['object_id' => $id])->all();

        $chekRoomUser = RoomObjectUser::find()->where(['object_id' => $id])->andWhere(['active' => 1])->all();

        $commentList = new ActiveDataProvider([
            'query' => CommentObject::find()->where(['object_id' => $id])->orderBy(['path' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $userFoll = RoomObjectUser::find()
            ->where(['object_id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->one();

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

        $post = Yii::$app->request->post();
        if ($post) {
            $userRoom->object_id = $id;
            $userRoom->user_id = Yii::$app->user->id;
            if ($userRoom->load($post) && $userRoom->validate() && $userRoom->save()) {
                $object = Object::findOne($id);
                if ($object) {
                    $object->status_object = 1;
                    $object->save();
                    $user = UserModel::find()->where(['id' => $userRoom->user_id])->one();
                    Yii::$app->email->subscribeObject($user->email, $object->title);
                }
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        $listViewCheckboxes = AttributeCheckbox::find()
            ->joinWith('groupCheckboxes')
            ->all();

        $objectValue = Object::findOne($id);

        $objectChecked = $objectValue->objectCheckboxes;

        $objectGroupCheckboxes = ArrayHelper::getColumn($objectChecked, 'group_id');

        $confidences = Confidence::find()->indexBy('id')->all();
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
            'userRoom' => $userRoom,
            'userFoll' => $userFoll,
            'commentNew' => $commentNew,
            'commentList' => $commentList,
            'modelImgs' => $modelImgs,
            'modelFiles' => $modelFiles,
            'progress' => $progress,
            'confObj' => $confObj,
            'listViewCheckboxes' => $listViewCheckboxes,
            'objectGroupCheckboxes' => $objectGroupCheckboxes,
            'objectConfidences' => $objectConfidences,
            'objectConfidencesFiles' => $objectConfidencesFiles,
            'confidences' => $confidences
        ]);
    }

    /* сохраняем комментарий */
    public function actionComment()
    {
        if (Yii::$app->request->post('CommentObject')) {
            $user = UserModel::findOne(Yii::$app->user->id);
            if ($user) {
                $comment = new CommentObject();
                $comment->load(Yii::$app->request->post());
                $comment->user_id = $user->id;
                $comment->user_name = $user->last_name . ' ' . $user->first_name;
                if ($comment->validate() && $comment->save()) {
                    if (Yii::$app->request->post('CommentObject')['comment_id']) {
                        $path = CommentObject::findOne(Yii::$app->request->post('CommentObject')['comment_id']);
                        $comment->path = $path->path . $comment->id . '.';
                    } else {
                        $comment->path = $comment->id . '.';
                    }

                    $comment->save();
                }
            }

        }
        return $this->redirect(['view', 'id' => Yii::$app->request->post('CommentObject')['object_id']]);
    }

    protected function findModel($id)
    {
        if (($model = Object::find()->where(['id' => $id])->andWhere(['!=', 'status_object', 0])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Объект не найден.');
    }

    /* отписавться user */
    public function actionUnsubscribe($oId)
    {
        if (isset($oId)) {
            $this->unsubscribeAll($oId, Yii::$app->user->id);
            $object = Object::find()->where(['id' => $oId])->one();
            $user = UserModel::find()->where(['id' => Yii::$app->user->id])->one();
            Yii::$app->email->unsubscribeObject($user->email, $object->title);
        } else {
            throw new NotFoundHttpException('Вы передали не все параметры');
        }
    }

    protected function unsubscribeAll($oId, $uId)
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

    private function filter()
    {
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

    /* доверие объекту */
    private function confObj($obId)
    {
        $allListConf = count(Confidence::find()->all());
        $listConf = count(ConfidenceObject::find()->where(['object_id' => $obId])->all());
        return round($listConf * 100 / $allListConf, 2);
    }

    public function actionUploadDocumentsZip($id)
    {
        $modelFiles = ObjectFile::find()->where(['object_id' => $id])->all();
        $webroot = \Yii::getAlias('@webroot');
        $zipFileName = "documents-{$id}.zip";
        $zipFilePath = "{$webroot}/uploads/objects/doc/{$id}/{$zipFileName}";
        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            if (!empty($modelFiles)) {
                $files = [];
                foreach ($modelFiles as $fileModel) {
                    if (!empty($fileModel->doc) && file_exists($webroot . $fileModel->doc)) {
                        $filePathArray = explode('/', $fileModel->doc);
                        $fileName = $filePathArray[count($filePathArray) - 1];
                        $zip->addFile($webroot . $fileModel->doc, $fileName);
                        $files[] = $fileName;
                    }
                }
                $zip->close();
                if (is_file($zipFilePath)) {
                    if (!empty($files)) {
                        return Yii::$app->response->sendFile($zipFilePath, $zipFileName);
                    }
                    unlink($zipFilePath);
                }
            }
        }
        return $this->redirect(['catalog/view', 'id' => $id]);
    }
}
