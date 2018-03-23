<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавить новый доступ';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['class' => 'form-horizontsl' ]); ?>

<?= $form->field($model, 'name_cr')->textInput(); ?>

<?= $form->field($model, 'description_cr')->textInput()->label('Название доступа (ru)'); ?>

<div class="form-group">
    <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
