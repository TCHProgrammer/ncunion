<?php
namespace backend\modules\test\controllers;
use backend\components\controllers\DefaultBackendController;
use backend\modules\rbac\models\AuthItem;
use Yii;
use yii\filters\AccessControl;
class DefaultController extends DefaultBackendController
{

    public function actionIndex(){

        return '11ddd';
    }


}
