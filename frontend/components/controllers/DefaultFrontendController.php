<?php
namespace frontend\components\controllers;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
class DefaultFrontendController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['no_pay', 'user', 'admin']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['/check-user']);
                }

            ],
        ];
    }

}