<?php
namespace frontend\controllers;

use common\components\Smsc;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class TariffsController extends Controller {

    public $layout = "tariffs_layout";

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionOptimal()
    {
        return $this->render("optimal");
    }

}