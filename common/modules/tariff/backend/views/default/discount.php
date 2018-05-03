<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\tariff\models\Tariff */

$this->title = 'Create Tariff';
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tariff-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'number')->textInput() ?>

        <?= $form->field($model, 'type')->dropDownList(
            [
                1 => '%',
                2 => '-'
            ],
            ['prompt' => 'Выберите тип объекта...']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
