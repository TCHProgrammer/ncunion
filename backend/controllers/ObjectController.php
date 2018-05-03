<?php

namespace backend\controllers;

use Yii;
use common\models\object\Object;
use backend\models\ObjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\controllers\DefaultBackendController;
use yii\filters\AccessControl;
use common\models\object\ObjectAttribute;
use common\models\object\Attribute;
use yii\base\Model;

/**
 * ObjectController implements the CRUD actions for Object model.
 */
class ObjectController extends DefaultBackendController
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
     * Lists all Object models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Object model.
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
     * Creates a new Object model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Object();
        $values = $this->initValues($model);

        $model->attributes['created_at'] = time();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save() &&  Model::loadMultiple($values, $post)) {
            $this->processValues($values, $model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'values' => $values,
        ]);
    }

    /**
     * Updates an existing Object model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $values = $this->initValues($model);
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->updateDate() && $model->save() &&  Model::loadMultiple($values, $post)) {
            $this->processValues($values, $model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'values' => $values,
        ]);
    }

    /**
     * Deletes an existing Object model.
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
     * Finds the Object model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Object the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Object::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function initValues(Object $model){
        $values = $model->getObjectAttributes()->indexBy('attribute_id')->all();
        $attributes = Attribute::find()->indexBy('id')->all();

        foreach (array_diff_key($attributes, $values) as $attribute) {
            $values[$attribute->id] = new ObjectAttribute(['attribute_id' => $attribute->id]);
        }

       /*foreach ($values as $value) {
            $value->setScenario(ObjectAttribute::SCENARIO_TABULAR);
        }*/

        return $values;
    }

    private function processValues($values, Object $model)
    {
        foreach ($values as $value) {
            $value->object_id = $model->id;

            $objectAttrinute = ObjectAttribute::find()
                                    ->where(['object_id' => $model->id])
                                    ->andWhere(['attribute_id' => $value->attribute_id])
                                    ->one();

            $checkAttr = Attribute::findOne($value->attribute_id);
            if ($model->type_id == $checkAttr->type_id) {
                if ($objectAttrinute) {
                    if ($value->value === '') {
                        $objectAttrinute->delete(['object_id' => $model->id, 'attribute_id' => $value->attribute_id]);
                    } else {
                        $objectAttrinute->value = $value->value;
                        $objectAttrinute->save();
                    }
                } else {
                    if (str_replace(' ', '', $value->value)) {
                        $value->save(false);
                    }
                }
            }else{
                if($objectAttrinute){
                    $objectAttrinute->delete(['object_id' => $model->id, 'attribute_id' => $value->attribute_id]);
                }
            }
        }
    }

}
