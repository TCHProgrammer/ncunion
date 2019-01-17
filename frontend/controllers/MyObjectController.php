<?php

namespace frontend\controllers;

use Yii;
use frontend\components\controllers\DefaultFrontendController;
use yii\filters\AccessControl;
use frontend\models\MyObjectSearch;

class MyObjectController extends DefaultFrontendController{

    public $layout = "user_layout";

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user', 'admin', 'broker']
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
        $searchModel = new MyObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }
}
