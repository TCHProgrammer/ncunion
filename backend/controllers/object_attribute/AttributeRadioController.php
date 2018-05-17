<?php

namespace backend\controllers\object_attribute;

use common\models\object\GroupRadio;
use Yii;
use common\models\object\AttributeRadio;
use backend\models\object_attribute\AttributeRadioSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\components\controllers\DefaultBackendController;

/**
 * AttributeRadioController implements the CRUD actions for AttributeRadio model.
 */
class AttributeRadioController extends DefaultBackendController{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['can_create_object'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all AttributeRadio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttributeRadioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AttributeRadio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AttributeRadio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AttributeRadio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $groupList = $this->findModelGroup($id);

        $addGroup = new GroupRadio();

        if (Yii::$app->request->post('Group')){

            foreach (Yii::$app->request->post('Group') as $idRadio => $title){
                $item = GroupRadio::findOne($idRadio);
                if ($item){
                    $item->title = $title['title'];
                    if ($item->validate()){
                        $item->save();
                    }
                }
            }
        }

        if (Yii::$app->request->post('GroupRadio')){
            $addGroup->attribute_id = $id;
            if ($addGroup->load(Yii::$app->request->post()) && $addGroup->validate() && $addGroup->save()) {
                return $this->redirect(['update', 'id' => $id]);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'addGroup' => $addGroup,
            'groupList' => $groupList
        ]);



        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AttributeRadio model.
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

    public function actionDeleteItem($id, $attribute)
    {
        $model = GroupRadio::findOne($id);
        if ($model){
            $model->delete();
        }

        return $this->redirect(['update', 'id' => $attribute]);
    }

    /**
     * Finds the AttributeRadio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributeRadio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttributeRadio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelGroup($id)
    {
        if (($model = GroupRadio::find()->where(['attribute_id' => $id])->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
