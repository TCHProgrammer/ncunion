<?php
namespace backend\controllers;

use Yii;
use common\models\LoginForm;
use backend\components\controllers\DefaultBackendController;

/**
 * Site controller
 */
class SiteController extends DefaultBackendController
{

    public function actionIndex()
    {
		Yii::$app->cache->flush();
		//Yii::$app->frontendCache->flush();
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
		Yii::$app->cache->flush();
		//Yii::$app->frontendCache->flush();
		
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->redirect(['index']);
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }

}
