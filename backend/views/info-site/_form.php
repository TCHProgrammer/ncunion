<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InfoSite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-site-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bot_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'letter_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'letter_email_pass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'letter_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supp_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supp_phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
