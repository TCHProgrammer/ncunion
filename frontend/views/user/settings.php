<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Настройки';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <div class="col-lg-12">

        <?= Html::label('Текущая картинка') ?>
        <div class="form-update-pic">
            <?= Html::img($avatar->avatar) ?>
        </div>
        <?= $form->field($model, 'imageFile')->fileInput()?>

        <?//= $form->field($model, 'avatar', ['options' => ['class' => 'form-height']])->textInput() ?>

        <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-height']])->textInput() ?>

        <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-height']])->textInput() ?>

        <?= $form->field($model, 'middle_name', ['options' => ['class' => 'form-height']])->textInput() ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'form-height']])->textInput() ?>

        <?= $form->field($model, 'phone', ['options' => ['class' => 'form-height']])->textInput(['placeholder' => '+7 (___) ___ __ __']) ?>

        <?= $form->field($model, 'company_name', ['options' => ['class' => 'form-height']])->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>