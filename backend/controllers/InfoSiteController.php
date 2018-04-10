<?php

namespace backend\controllers;

use Yii;
use backend\components\controllers\DefaultBackendController;
use common\models\InfoSite;
use backend\models\InfoSiteSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * InfoSiteController implements the CRUD actions for InfoSite model.
 */
class InfoSiteController extends DefaultBackendController
{
    /**
     * @inheritdoc
     * info_site
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['info_site'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $infoSite = InfoSite::findOne(1);

        return $this->render('index', [
            'infoSite' => $infoSite
        ]);
    }

    public function actionUpdate()
    {
        $model = $this->findModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel()
    {
        if (($model = InfoSite::findOne(1)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
