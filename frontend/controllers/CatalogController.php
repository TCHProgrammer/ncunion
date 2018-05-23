<?php

namespace frontend\controllers;

use common\models\RoomFinishObject;
use common\models\RoomObjectUser;
use Yii;
use common\models\object\Object;
use frontend\models\ObjectSearch;
use yii\web\NotFoundHttpException;
use frontend\components\controllers\DefaultFrontendController;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class CatalogController extends DefaultFrontendController{

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

    public function actionIndex()
    {
        $searchModel = new ObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $userRoom = new RoomObjectUser();
        $model = $this->findModel($id);

        $userFoll = RoomObjectUser::find()
            ->where(['object_id' => $id])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->one();

        $usersObjectlist = new ActiveDataProvider([
            'query' => RoomObjectUser::find()
                ->where(['object_id' => $id])
                ->joinWith('user')
                ->joinWith('userAvatar'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $post = Yii::$app->request->post();
        if ($post){
            $userRoom->object_id = $id;
            $userRoom->user_id = Yii::$app->user->id;
            if ($userRoom->load($post) && $userRoom->validate() && $userRoom->save()){
                $object = Object::findOne($id);
                if ($object){
                    if ((int)$post['RoomObjectUser']['sum'] >= $object->amount){
                        $object->status_object = 0;
                    }else{
                        $object->status_object = 1;
                    }
                    $object->save();
                }
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'userRoom' => $userRoom,
            'userFoll' => $userFoll,
            'usersObjectlist' => $usersObjectlist
        ]);
    }

    public function actionUnsubscribe($oId)
    {
        $this->unsubscribeAll($oId, Yii::$app->user->id);
    }

    public function actionUnsubscribeAdm($oId, $uId)
    {
        $this->unsubscribeAll($oId, $uId);
    }

    public function actionObjectFinishAdm($oId, $uId)
    {
        $mId = Yii::$app->user->id;
        $this->modelObjectFinish($oId, $uId, $mId);
        return $this->redirect(['view', 'id' => $oId]);
    }

    protected function findModel($id)
    {
        if (($model = Object::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function unsubscribeAll($oId, $uId)
    {
        $userList = RoomObjectUser::find()
            ->where(['object_id' => $oId])
            ->andWhere(['user_id' => $uId])
            ->one();

        if ($userList){
            $userList->delete(['object_id' => $oId, 'user_id' => Yii::$app->user->id]);
        }

        $checkRoomObjects = RoomObjectUser::find()
            ->where(['object_id' => $oId])
            ->all();

        $object = Object::findOne($oId);
        if (!$checkRoomObjects ){
            $object->status_object = 2;
        }else{
            foreach ($checkRoomObjects as $checkRoomObject){
                if ($checkRoomObject->sum >= $object->amount){
                    $object->status_object = 0;
                }else{
                    $object->status_object = 1;
                }
            }
        }

        $object->save();

        return $this->redirect(['view', 'id' => $oId]);
    }

    protected function modelObjectFinish($oId, $uId, $mId=null)
    {
        $model = new RoomFinishObject();
        if ($model){
            $model->object_id = $oId;
            $model->user_id = $uId;
            $model->manager_id = $mId;
            if ($model->validate()){
                if ($model->save()){
                    if ($this->modelObjectStatusEnd($oId)){
                        return true;
                    };
                }
            }
        }

        return false;
    }

    protected function modelObjectStatusEnd($oId)
    {
        $object = Object::findOne($oId);
        if ($object){
            $object->status_object = 0;
            if ($object->validate()){
                if ($object->save()){
                    return true;
                }
            }
        }

        return false;
    }
}
