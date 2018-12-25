<?php
namespace frontend\controllers;

use common\components\Smsc;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class PolicyController extends Controller {

    public $layout = "page_layout";

    public function actionIndex()
    {
        return $this->render("index");
    }

}