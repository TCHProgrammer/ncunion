<?php
namespace backend\modules\rbac\controllers;
use backend\components\controllers\DefaultBackendController;
use backend\modules\rbac\models\AuthItem;
use Yii;
use yii\filters\AccessControl;
class PermissionController extends DefaultBackendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin_menu_rbac_permission'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){

        $roles = AuthItem::find()->where(['type' => 2])->all();

        return $this->render('index', [
            'roles' => $roles
        ]);
    }

    public function actionCreatePermission(){

        $model = new AuthItem();

        if (isset($_POST['AuthItem'])){

            $name_cr = $_POST['AuthItem']['name_cr'];
            $description_cr = $_POST['AuthItem']['description_cr'];

            if ( $this->checkPost($name_cr) && $this->checkPost($description_cr)) {
                $permission = Yii::$app->authManager->createPermission($name_cr);
                $permission->description = $description_cr;
                Yii::$app->authManager->add($permission);

                return $this->redirect('index');
            }
        }

        return $this->render('create_permission', [
            'model' => $model
        ]);
    }

    public function checkPost($post){
        if(empty($post)){
            return false;
        }else{
            if(!(ctype_space($post))){
                return true;
            }else{
                return false;
            }
        }
    }
}
