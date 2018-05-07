<?php
namespace backend\controllers;

use common\models\object\ObjectImg;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\components\controllers\DefaultBackendController;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends DefaultBackendController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
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

        return $this->goHome();
    }

    public function actionSaveImg(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@frontend') . '/web/uploads/objects/img/' . $post['object_id'] .'/';

            if (!is_dir($dir)){
                FileHelper::createDirectory($dir);
            }

            $result_link = str_replace('admin', '', Url::home(true) . 'uploads/object/img/' . $post['object_id'] .'/');
            $file = UploadedFile::getInstancesByName( 'imgFile');
            $file = array_shift($file);

            if (is_null($file)){
                return 'Файлы уже загруженны';
            }

            $imgName = strtotime('now') . '_' . Yii::$app->security->generateRandomString(8). '.' . $file->getExtension();

            $fullName = $dir . $imgName;

            $model = new ObjectImg();
            $model->object_id = $post['object_id'];
            $model->img = 'uploads/objects/img/' . $post['object_id'] .'/' . $imgName;

            if ($model->validate()){
                if($file->saveAs($fullName)){
                    if($model->save()){
                        $resilt = [
                            'filelink' => $result_link . $fullName
                        ];
                    };
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $resilt;
        }
    }
}
