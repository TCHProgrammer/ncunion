<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\object\ObjectType;
use common\models\passport\FormParticipation;

$this->title="Паспорт клиента";
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="object-form">
    <div class="row">

        <?php $form = ActiveForm::begin(); ?>

        <div class="col-lg-6">
            <?= $form->field($model, 'type_id', ['options' => ['class' => 'form-height']])->dropDownList(
                ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                ['prompt' => 'Выберите тип объекта...']
            ) ?>

            <?= $form->field($model, 'amount', ['options' => ['class' => 'form-height']])->textInput() ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'area', ['options' => ['class' => 'form-height']])->textInput() ?>

            <?= $form->field($model, 'rooms', ['options' => ['class' => 'form-height']])->textInput() ?>
        </div>

        <div class="col-lg-12">
            <?= $form->field($model, 'form_participation_id')->radioList(ArrayHelper::map(FormParticipation::find()->all(), 'id', 'title')) ?>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
