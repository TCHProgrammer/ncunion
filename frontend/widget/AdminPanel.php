<?php
namespace frontend\widget;
use yii\base\Widget;
use Yii;

class AdminPanel extends Widget{

    public function run(){

        /*if (!Yii::$app->user->can('canAdmin'))
            return false;*/

        return $this->render('admin-panel');
    }

}