<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;
use common\models\object\Prescribed;
use common\models\object\Attribute;
use mihaildev\ckeditor\CKEditor;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="object-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
        ['prompt' => 'Выберите тип объекта...']
    ) ?>

    <?//= $form->field($model, 'imgFile')->fileInput() ?>
    <?= FileInput::widget([
            'model' => $model,
            'attribute' => 'imgFile[]',
            'options' => ['multiple' => true],
            //'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => Url::to(['/site/file-upload'])]
        ]);
    ?>

    ////////////////////////////////////////////////
    <?php foreach ($values as $value): ?>
        <?php $attribute = Attribute::findOne($value->attribute_id) ?>
        <div class="form-attribute-<?= $attribute->type_id ?>">
            <?= $form->field($value, '[' . $value->attribute0->id . ']value')->label($value->attribute0->title); ?>
        </div>
    <?php endforeach; ?>
    ///////////////////////////////////////////////

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'status_object')->dropDownList([
        1 => 'Сделка открыта',
        0 => 'Сделка закрыта'
    ]) ?>

    <?//= $form->field($model, 'sticker_id')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]); ?>

    <?= $form->field($model, 'place_km')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_map')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area')->textInput() ?>

    <?= $form->field($model, 'rooms')->textInput() ?>

    <?= $form->field($model, 'noticesArray')->checkboxList(
        Prescribed::find()->select(['title', 'id'])->indexBy('id')->column()
    ) ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_cadastral')->textInput() ?>

    <?= $form->field($model, 'price_tian')->textInput() ?>

    <?= $form->field($model, 'price_market')->textInput() ?>

    <?= $form->field($model, 'price_liquidation')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
