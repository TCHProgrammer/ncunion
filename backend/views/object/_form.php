<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="object-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
        ['prompt' => 'Выберите тип объекта...']
    ) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'place_km')->dropDownList([
        0 => 'Москва',
        5 => 'МКАД до 5 км',
        15 => 'МКАД до 15 км',
        25 => 'МКАД до 25 км',
        50 => 'МКАД до 50 км',
        100 => 'МКАД до 100 км',
    ]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_map')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area')->textInput() ?>

    <?= $form->field($model, 'rooms')->textInput() ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_cadastral')->textInput() ?>

    <?= $form->field($model, 'price_tian')->textInput() ?>

    <?= $form->field($model, 'price_market')->textInput() ?>

    <?= $form->field($model, 'price_liquidation')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
