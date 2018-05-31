<?php

namespace backend\controllers;

use Yii;
use common\models\RoomFinishObject;
use backend\models\ObjectFinishSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ObjectFinishController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['can_check_finish_object'],
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

    public function actionIndex()
    {
        $searchModel = new ObjectFinishSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($object_id, $user_id)
    {
        $del = RoomFinishObject::find()
            ->where(['object_id' => $object_id])
            ->andWhere(['user_id' => $user_id])
            ->one();
        if ($del) {
            $del->delete(['object_id' => $object_id, 'user_id' => $user_id]);
        }

        return $this->redirect(['index']);
    }
}
