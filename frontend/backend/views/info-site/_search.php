<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\InfoSiteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-site-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'bot_title') ?>

    <?= $form->field($model, 'descr') ?>

    <?= $form->field($model, 'letter_email') ?>

    <?= $form->field($model, 'letter_phone') ?>

    <?php // echo $form->field($model, 'supp_email') ?>

    <?php // echo $form->field($model, 'supp_phone') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
