<?php
namespace frontend\components\controllers;
use yii\filters\AccessControl;
use yii\web\Controller;
class DefaultFrontendController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['no_pay', 'user']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['/check-user']);
                }
            ],
        ];
    }

}