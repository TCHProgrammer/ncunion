<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\object\ObjectType;
$this->title="Паспорт клиента";
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="object-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
        ['prompt' => 'Выберите тип объекта...']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
