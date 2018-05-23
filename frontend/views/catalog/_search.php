<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model frontend\models\ObjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="object-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <div class="row">
        <?= $form->field($model, 'title', ['options' => ['class' => 'input-adjustment col-lg-5 col-md-5']]) ?>

        <?= $form->field($model, 'type_id', ['options' => ['class' => 'input-adjustment col-lg-3 col-md-3']])->dropDownList(
            ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
            ['prompt' => 'Выберите тип объекта...']
        ) ?>

        <?= $form->field($model, 'place_km', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'amount', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'area', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'rooms', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_cadastral', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_tian', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_market', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_liquidation', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Очистить', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
