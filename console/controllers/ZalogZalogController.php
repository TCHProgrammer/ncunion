<?php
namespace console\controllers;
use yii\console\Controller;
use Yii;
use common\models\User;
class ZalogZalogController extends Controller
{
    public function actionIndex() {

        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = 'Контент менеджер';
        Yii::$app->authManager->add($manager);

        $no_pay = Yii::$app->authManager->createRole('no_pay');
        $no_pay->description = 'Подписка закончилась';
        Yii::$app->authManager->add($no_pay);
    }
}