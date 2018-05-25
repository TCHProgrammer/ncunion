<?php

namespace frontend\controllers;

use common\models\CommentObject;
use common\models\RoomFinishObject;
use common\models\RoomObjectUser;
use common\models\UserModel;
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
        $commentNew = new CommentObject();
        $model = $this->findModel($id);
        $chekFinishObject = RoomFinishObject::find()->where(['object_id' => 3])->one();

        $commentList = new ActiveDataProvider([
            'query' => CommentObject::find()->where(['object_id' => 3]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (is_null($chekFinishObject)){
            $finishObject = true;
        }else{
            $finishObject = false;
        }

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
                        $this->modelObjectFinish($id, Yii::$app->user->id);
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
            'usersObjectlist' => $usersObjectlist,
            'finishObject' => $finishObject,
            'commentNew' => $commentNew,
            'commentList' => $commentList
        ]);
    }

    /* сохраняем комментарий */
    public function actionComment()
    {
        if (Yii::$app->request->post('CommentObject')){
            $user = UserModel::findOne(Yii::$app->user->id);
            if ($user){
                $comment = new CommentObject();
                $comment->load(Yii::$app->request->post());
                $comment->user_id = $user->id;
                $comment->user_name = $user->last_name . ' ' . $user->first_name;
                if ($comment->validate()){
                    $comment->save();
                }
            }

        }
        return $this->redirect(['view', 'id' => Yii::$app->request->post('CommentObject')['object_id']]);
    }

    /* отписавться user */
    public function actionUnsubscribe($oId)
    {
        $this->unsubscribeAll($oId, Yii::$app->user->id);
    }

    /* отписавться adm */
    public function actionUnsubscribeAdm($oId, $uId)
    {
        $this->unsubscribeAll($oId, $uId);
    }

    /* отдать инвестору adm */
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
