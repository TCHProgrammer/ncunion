<?php
namespace extensions\modules\news\controllers;
use backend\components\controllers\DefaultBackendController;

class DefaultController extends DefaultBackendController {

    public function actionsIndex(){
        return $this->render('index');
    }

}