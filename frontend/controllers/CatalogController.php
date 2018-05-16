<?php

namespace frontend\controllers;
use Frontend\components\controllers\DefaultFrontendController;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\object\Object;

class CatalogController extends Controller{

    public function behaviors(){
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

    public function actionIndex(){

        $dataProvider = new ActiveDataProvider([
            'query' => Object::find()->where(['status' => 1])->andWhere()->all(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index');
    }
}