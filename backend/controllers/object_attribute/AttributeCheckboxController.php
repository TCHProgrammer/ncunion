<?php

namespace backend\controllers\object_attribute;

use common\models\object\GroupCheckbox;
use Yii;
use common\models\object\AttributeCheckbox;
use backend\models\object_attribute\AttributeCheckboxSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\components\controllers\DefaultBackendController;

/**
 * AttributeCheckboxController implements the CRUD actions for AttributeCheckbox model.
 */
class AttributeCheckboxController extends DefaultBackendController
{
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
     * Lists all AttributeCheckbox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttributeCheckboxSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AttributeCheckbox model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AttributeCheckbox();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]); //'view', 'id' => $model->id
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AttributeCheckbox model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $groupList = $this->findModelGroup($id);

        $addGroup = new GroupCheckbox();

        if (Yii::$app->request->post('Group')){

            foreach (Yii::$app->request->post('Group') as $idCheckbox => $title){
                $item = GroupCheckbox::findOne($idCheckbox);
                if ($item){
                    $item->title = $title['title'];
                    if ($item->validate()){
                        $item->save();
                    }
                }
            }

            /*$addGroup->attribute_id = $id;
            if ($addGroup->load(Yii::$app->request->post()) && $addGroup->validate() && $addGroup->save()) {
                return $this->redirect(['update', 'id' => $id]);
            }*/
        }

        if (Yii::$app->request->post('GroupCheckbox')){
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
    }

    /**
     * Deletes an existing AttributeCheckbox model.
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
        $model = GroupCheckbox::findOne($id);
        if ($model){
            $model->delete();
        }

        return $this->redirect(['update', 'id' => $attribute]);
    }

    /**
     * Finds the AttributeCheckbox model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributeCheckbox the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttributeCheckbox::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelGroup($id)
    {
        if (($model = GroupCheckbox::find()->where(['attribute_id' => $id])->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
