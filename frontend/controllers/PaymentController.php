<?php
namespace frontend\controllers;
use common\modules\tariff\models\Tariff;
use frontend\components\controllers\DefaultFrontendController;
use yii\web\Controller;
use yii\filters\AccessControl;

class PaymentController extends DefaultFrontendController{

    public function actionPay(){

        $tariffs = Tariff::find()->where(['status' => 1])->joinWith('discount')->all();

        return $this->render('pay', [
            'tariffs' => $tariffs
        ]);
    }



}