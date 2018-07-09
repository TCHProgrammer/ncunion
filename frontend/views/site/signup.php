<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\maskedinput\MaskedInput;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <div class="col-lg-6">

            <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-height']])->textInput() ?>

            <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-height']])->textInput() ?>

            <?= $form->field($model, 'middle_name', ['options' => ['class' => 'form-height']])->textInput() ?>

            <?= $form->field($model, 'email', ['options' => ['class' => 'form-height']])->textInput() ?>

        </div>

        <div class="col-lg-6">

            <?= $form->field($model, 'phone', ['options' => ['class' => 'form-height']])->widget(MaskedInput::className(), [
                'mask' => '+7(999)999-9999',
            ]) ?>

            <?= $form->field($model, 'company_name', ['options' => ['class' => 'form-height']])->textInput() ?>

            <?= $form->field($model, 'password', ['options' => ['class' => 'form-height']])->passwordInput() ?>

            <?= $form->field($model, 'password_repeat', ['options' => ['class' => 'form-height']])->passwordInput() ?>

        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

