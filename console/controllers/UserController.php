<?php
namespace console\controllers;

use Yii;
use common\models\User;
use yii\helpers\Console;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class UserController extends Controller
{
    /**
     * Creates new user.
     * @return void
     */
    public function actionCreate()
    {
        $user = new User();
        //$this->readValue($user, 'first_name');
        $this->readValue($user, 'email');
        $user->setPassword($this->prompt('Password:', [
            'required' => true,
            'pattern'  => '#^.{4,255}$#i',
            'error'    => 'More than 6 symbols',
        ]));
        $user->generateAuthKey();
        $this->log($user->save());
    }
    
    /**
     * Adds role to user.
     * @return void
     */
    public function actionAssign()
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $authManager = Yii::$app->getAuthManager();
        $roleName = $this->select('Role:', ArrayHelper::map($authManager->getRoles(), 'name', 'description'));
        $role = $authManager->getRole($roleName);
        $authManager->assign($role, $user->id);
        $this->stdout('Done!' . PHP_EOL);
    }
    
     /**
     * Find user.
     * @param string $email
     * @throws \yii\console\Exception
     * @return User the loaded model
     */
    private function findModel($email)
    {
        if (!$model = User::findOne(['email' => $email])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
    
    
    /**
     * Get the value of the console.
     * @param Model $user
     * @param string $attribute
     * @return mixed
     */
    private function readValue($user, $attribute)
    {
        $user->$attribute = $this->prompt(mb_convert_case($attribute, MB_CASE_TITLE, 'utf-8') . ':', [
            'validator' => function ($input, &$error) use ($user, $attribute) {
                $user->$attribute = $input;
                if ($user->validate([$attribute])) {
                    return true;
                } else {
                    $error = implode(',', $user->getErrors($attribute));
                    return false;
                }
            },
        ]);
    }
    
     /**
     * Console log.
     * @param bool $success
     * @return void
     */
    private function log($success)
    {
        if ($success) {
            $this->stdout('Success!', Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr('Error!', Console::FG_RED, Console::BOLD);
        }
        $this->stdout(PHP_EOL);
    }
}