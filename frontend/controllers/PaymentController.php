<?php
namespace frontend\controllers;
use frontend\components\controllers\DefaultFrontendController;
use yii\web\Controller;
use yii\filters\AccessControl;

class PaymentController extends DefaultFrontendController{

    public function actionPay(){
        return $this->render('pay');
    }



}