<?php
namespace frontend\widget;
use yii\base\Widget;
use Yii;

class AdminPanel extends Widget{

    public function run(){

        if (!Yii::$app->user->can('widgetAdminPanel'))
            return false;

        return $this->render('admin-panel');
    }

    public function actionCache(){
        var_dump('actionCache');die;
    }

}