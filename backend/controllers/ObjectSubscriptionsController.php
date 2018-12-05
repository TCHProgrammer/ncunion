<?php


namespace backend\controllers;


use backend\components\controllers\DefaultBackendController;
use common\models\RoomObjectUser;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class ObjectSubscriptionsController extends DefaultBackendController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['can_create_object', 'admin_menu_object_subscriptions'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = RoomObjectUser::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
