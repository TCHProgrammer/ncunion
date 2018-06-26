<?php
namespace common\components;
use yii\base\Component;
use Yii;
use yii\web\ForbiddenHttpException;

class CudComponent extends Component{

    public function init(){
        parent::init();
    }

    public function create(){
        if (!Yii::$app->user->can('create')){
            throw new ForbiddenHttpException('У вас недостаточно прав.');
        }
    }

    public function update(){
        if (!Yii::$app->user->can('update')){
            throw new ForbiddenHttpException('У вас недостаточно прав.');
        }
    }

    public function delete(){
        if (!Yii::$app->user->can('delete')){
            throw new ForbiddenHttpException('У вас недостаточно прав.');
        }
    }
}