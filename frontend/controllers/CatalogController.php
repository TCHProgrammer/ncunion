<?php

namespace frontend\controllers;
use Frontend\components\controllers\DefaultFrontendController;
use yii\web\Controller;
use yii\filters\AccessControl;

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
        return $this->render('index');
    }
}