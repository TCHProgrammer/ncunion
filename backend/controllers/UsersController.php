<?php

namespace backend\controllers;

use backend\modules\rbac\models\AuthAssignment;
use backend\modules\rbac\models\AuthItem;
use Yii;
use common\models\UserModel;
use backend\models\UserSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use backend\components\controllers\DefaultBackendController;
use backend\models\SignupForm;

/**
 * UsersController implements the CRUD actions for UserModel model.
 */
class UsersController extends DefaultBackendController
{
    /**
     * Lists all UserModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $listRoles = ArrayHelper::map(AuthItem::find()->where(['type' => 1])->all(), 'name', 'description');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'listRoles' => $listRoles
        ]);
    }

    /**
     * Displays a single UserModel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = time();

        $role = AuthAssignment::find()->where(['user_id' => $id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save() && $role->load(Yii::$app->request->post()) && $role->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'role' => $role
        ]);
    }

    /**
     * Deletes an existing UserModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionUsersModer()
    {
        $post = Yii::$app->request->post('UserModel');
        if ($post) {
            $userUpdate = AuthAssignment::find()->where(['user_id' => $post['user_id']])->one();
            $user = UserModel::find()->where(['id' => $post['user_id']])->one();
            if ($post['ban_user']) {
                $userUpdate->item_name = 'ban';
                $userUpdate->save();
                $contentMas = [
                    'text' => 'Ваш аккаунт не подтвержден администратором',
                    'htmlA' => ''
                ];
                Yii::$app->email->checkModerate($user->email, $contentMas);
            } else {
                $userUpdate->item_name = $post['item_name'];
                if ($userUpdate->save()) {
                    if ($userUpdate->item_name == 'broker') {
                        $link = Html::a('Перейти к управлению', Yii::$app->urlManager->createAbsoluteUrl('object'), ['style' => 'color:#ebec8b']);
                    } else {
                        $link = Html::a('Перейти в каталог', Yii::$app->urlManagerFrontend->createAbsoluteUrl('catalog'), ['style' => 'color:#ebec8b']);
                    }
                    $role = $userUpdate->getItemName()->one();
                    $contentMas = [
                        'text' => "Поздравляем, вам назначен статус {$role->description}. Доступ к системе открыт",
                        'htmlA' => $link
                    ];
                    Yii::$app->email->checkModerate($user->email, $contentMas);
                }
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => UserModel::find()
                ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->where(['auth_assignment.item_name' => 'unknown'])
                ->andWhere(['check_email' => 1, 'check_phone' => 1])
//                ->andWhere(['not', ['user_passport_id' => null]])
                ->orderBy('created_at ASC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('users-moder', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreateUser()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->redirect(['/users/view', 'id' => $user->id]);
            }
        }

        return $this->render('create-user', [
            'model' => $model,
        ]);
    }
}
