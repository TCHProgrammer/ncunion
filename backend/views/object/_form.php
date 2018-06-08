<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;
use common\models\object\Prescribed;
use common\models\object\Attribute;
use mihaildev\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row col-lg-12">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->checkbox() ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'type_id', ['options' => ['class' => 'col-lg-6 col-md-6']])->dropDownList(
            ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
            ['prompt' => 'Выберите тип объекта...']
        ) ?>

        <?= $form->field($model, 'status_object', ['options' => ['class' => 'col-lg-6 col-md-6']])->dropDownList([
            2 => 'Сделка открыта',
            1 => 'Сделка частично закрыта',
            0 => 'Сделка закрыта'
        ]) ?>

    </div>

    <div class="row col-lg-12">
        <?= $form->field($model, 'descr')->widget(CKEditor::className(),[
            'editorOptions' => [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
            ],
        ]); ?>

        <?php if (!$model->isNewRecord){ ?>
            <label class="control-label">Фотогалерея</label>
            <?= FileInput::widget([
                /*'model' => $model,
                'attribute' => 'imgFile[]',
                'options' => ['multiple' => true],*/
                //'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => Url::to(['/site/file-upload'])]
                'name' => 'imgFile[]',
                'options'=>[
                    'multiple'=>true
                ],
                'pluginOptions' => [
                    'deleteUrl' => Url::toRoute(['/object/delete-img']),
                    'initialPreview' => $model->imgLists,
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => false,
                    'initialPreviewConfig' => $model->imgLinkData,
                    'uploadUrl' => Url::to(['/object/save-img']),
                    'uploadExtraData' => [
                        'class' => $model->formName(),
                        'object_id' => $model->id,
                    ],
                    'maxFileCount' => 10
                ],
                //'options' => ['accept' => 'image/*'],
                'pluginEvents' => [
                    'filesorted' => new JsExpression('function(event, params){
                    $.post("' . Url::toRoute(['/object/sort-img?id=' .
                        $model->id]).'",{sort:params});
                }')
                ]
            ]);
            ?>
            <br>
        <?php } ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'place_km', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'amount', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'area', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>

        <?= $form->field($model, 'rooms', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>
    </div>

    <div class="row col-lg-12">
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address_map')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'noticesArray')->checkboxList(
            //Prescribed::find()->select(['title', 'id'])->indexBy('id')->column()
            ArrayHelper::map(Prescribed::find()->all(), 'id', 'title')
        ) ?>

        <?= $form->field($model, 'owner')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'price_cadastral', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>

        <?= $form->field($model, 'price_tian', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>

        <?= $form->field($model, 'price_market', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>

        <?= $form->field($model, 'price_liquidation', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>
    </div>

    <div class="row">
        <?php foreach ($values as $value): ?>
            <?php $attribute = Attribute::findOne($value->attribute_id) ?>
            <div class="form-attribute-<?= $attribute->type_id ?>">
                <?= $form->field($value, '[' . $value->attribute0->id . ']value', ['options' => ['class' => 'col-lg-6 col-md-6']])->label($value->attribute0->title); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row row-padding">
        <?php foreach ($listCheckbox as $itemCheckbox){ ?>
            <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>">
                <label><?= $itemCheckbox->title ?></label>
                <div>
                    <?php foreach ($itemCheckbox->groupCheckboxes as $itemGroup){ ?>
                        <label class="checkbox">
                            <input type="checkbox" name="GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>][]" value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezCheckbox))?'checked':'' ?>>
                            <?= $itemGroup->title ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row row-padding">
        <?php foreach ($listRadio as $itemRadio){ ?>
            <div class="form-attribute form-attribute-<?= $itemRadio->type_id ?>">
                <label><?= $itemRadio->title ?></label>
                    <?php foreach ($itemRadio->groupRadios as $itemGroup){ ?>
                        <label class="radio">
                            <input type="radio" name="GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>][]" value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezRadio))?'checked':'' ?>>
                            <?= $itemGroup->title ?>
                        </label>
                    <?php } ?>
            </div>
        <?php } ?>
    </div>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

