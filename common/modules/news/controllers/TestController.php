<?php
namespace common\modules\news\controllers;
use backend\components\controllers\DefaultBackendController;

class TestController extends DefaultBackendController {

    public function actionsIndex(){
        return $this->render('index');
    }

}