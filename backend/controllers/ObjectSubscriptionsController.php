<?php


namespace backend\controllers;


use backend\components\controllers\DefaultBackendController;
use backend\modules\rbac\models\AuthAssignment;
use common\models\object\Object;
use common\models\RoomObjectUser;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use Yii;

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
        $role = AuthAssignment::find()->where(['user_id' => Yii::$app->user->id])->one();
        if (isset($role) && $role->item_name == 'broker') {
            $query = RoomObjectUser::find()->leftJoin(Object::tableName(), Object::tableName().".id=".RoomObjectUser::tableName().".object_id")->where([Object::tableName().'.broker_id' => Yii::$app->user->id]);
        } else {
            $query = RoomObjectUser::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
