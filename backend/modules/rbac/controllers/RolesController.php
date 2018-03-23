<?php
namespace backend\modules\rbac\controllers;
use backend\components\controllers\DefaultBackendController;
use backend\modules\rbac\models\AuthItem;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\AccessControl;
class RolesController extends DefaultBackendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin_menu_rbac_roles'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){

        $roles = AuthItem::find()->where(['type' => 1])->all();

        return $this->render('index', [
            'roles' => $roles
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

    public function actionCreate(){

        $model = new AuthItem();

        if (isset($_POST['AuthItem'])){

            $name_cr = $_POST['AuthItem']['name_cr'];
            $description_cr = $_POST['AuthItem']['description_cr'];

            if ( $this->checkPost($name_cr) && $this->checkPost($description_cr)) {
                $role = Yii::$app->authManager->createRole($name_cr);
                $role->description = $description_cr;
                Yii::$app->authManager->add($role);

                return $this->redirect('index');
            }
        }

        return $this->render('create', [
            'model' => $model
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

    public function actionDelete($role, $back){

        if (in_array($role,['admin','user','guest'])){
            var_dump('МОЯ ОШИБКА');die;
            throw new HttpException(403,'Невозможно удалить системные роли');
        }
        $auth = Yii::$app->authManager;
        $auth->remove($auth->getRole($role));

        return $this->redirect(urldecode($back));
    }


    public function actionUpdate($role)
    {
        $role = $this->findModel($role);
        return $this->modify($role);
    }

    protected function findModel($role)
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();

        if (isset($roles[$role])) {
            return $roles[$role];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function modify($role, $isNewModel = false)
    {
        $auth = Yii::$app->authManager;
        $permissions = $auth->getPermissions();
        $rolePermissions = $auth->getPermissionsByRole($role->name);
        $errors = [];
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post('permissions');
            $params = Yii::$app->request->post('role');

            if($isNewModel) {
                if(!trim($params['description'])){
                    $errors['description'][] = 'Имя роли не может быть пустым';
                }
            }

            if(count($errors) === 0) {
                if ($isNewModel) {
                    if(!trim($params['code'])){
                        $errors['code'][] = 'Код не может быть пустым';
                    }

                    if (in_array($params['code'], ['admin', 'contentEditor', 'user', 'guest'])) {
                        $errors['code'][] = "Невозможно создать роль с кодом \"{$params['code']}\"";
                    }
                }
            }

            if(count($errors) === 0) {
                $role->description = $params['description'];
                if($isNewModel) {
                    $auth->add($role);
                } else {
                    $auth->update($role->name, $role);
                }

                foreach ($permissions as $key => $val) {
                    if ($post[$key] && !$rolePermissions[$key])
                        $auth->addChild($role, $permissions[$key]);

                    if (!$post[$key] && $rolePermissions[$key])
                        $auth->removeChild($role, $permissions[$key]);
                }

                $this->redirect(['index']);
            }
        }

        $models = [];
        $permissionsKeys = array_keys($permissions);
        foreach ($permissionsKeys as $permission) {
            $models[] = [
                'name' => $permission,
                'description' => $permissions[$permission]->description,
                'assigned' => array_key_exists($permission, $rolePermissions)
            ];
        }

        return $this->render('update', [
            'models' => $models,
            'role'=>$role,
            'isNewModel'=>$isNewModel,
            'errors'=>$errors
        ]);
    }
}
