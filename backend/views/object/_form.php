<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;
use common\models\object\Attribute;
use mihaildev\ckeditor\CKEditor;
use common\models\Tag;
use common\models\object\Confidence;

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
    <?= $form->field($model, 'descr')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]); ?>

    <?php if (!$model->isNewRecord) { ?>
        <?= $this->render('_formImgs', [
            'model' => $model
        ]); ?>
    <?php } ?>
</div>

<div class="row">
    <?= $form->field($model, 'region_id', ['options' => ['class' => 'col-lg-3 col-md-6']])->dropDownList($region, ['prompt' => 'Выберите регион']) ?>

    <?php
    $cityTypeId = 0;
    foreach ($localityType as $id => $localityTyp) {
        if ($localityTyp == 'Город') {
            $cityTypeId = $id;
        }
    }
    $localityFieldId = Html::getInputId($model, 'locality_type_id');
    $cityFieldId = Html::getInputId($model, 'city_id');
    $regionFieldId = Html::getInputId($model, 'region_id');
    $placeKmFieldId = Html::getInputId($model, 'place_km');
    $roomFieldId = Html::getInputId($model, 'rooms');
    $placeTypeIdFieldId = Html::getInputId($model, 'type_id');
    $placeKmFieldHideShow = empty($model->place_km) ? 'hide' : 'show';
    $localityFieldHideShow = empty($model->locality_type_id) ? 'hide' : 'show';
    $cityFieldHideShow = empty($model->city_id) ? 'hide' : 'show';
    $commerceType = ObjectType::find()->where(['title' => 'Коммерция'])->one();
    $this->registerJs("
    $(document).ready(function () {
        $(\"#{$placeKmFieldId}\").parent().{$placeKmFieldHideShow}();
        $(\"#{$localityFieldId}\").parent().{$localityFieldHideShow}();
        $(\"#{$cityFieldId}\").parent().{$cityFieldHideShow}();
        $(\"#{$roomFieldId}\").parent().hide();
        getCities();
    
        $(document).on('change', '#{$cityFieldId}', function () {
            var mkad = $(\"#{$cityFieldId} option:selected\").data(\"mkad\");
            if (mkad) {
              $(\"#{$placeKmFieldId}\").parent().show();
            } else {
              $(\"#{$placeKmFieldId}\").parent().hide();
              $(\"#{$placeKmFieldId}\").val(0);
            }
        });
    
        $(document).on('change', '#{$regionFieldId}', function () {
            $(\"#{$localityFieldId}\").parent().show();
        });
        
        $(document).on('change', '#{$localityFieldId}', function () {
            $(\"#{$placeKmFieldId}\").val(0);
            if ($(\"#{$localityFieldId}\").val() == {$cityTypeId}) {
                $(\"#{$placeKmFieldId}\").parent().hide();
                getCities();
            } else {
                $(\"#{$cityFieldId}\").parent().hide();
                $(\"#{$placeKmFieldId}\").parent().show();
            }
        });
        
        $(document).on('change', '#{$placeTypeIdFieldId}', function() {
            if ($(\"#{$placeTypeIdFieldId}\").val() == {$commerceType->id}) {
                $(\"#{$roomFieldId}\").parent().hide();
            } else {
                $(\"#{$roomFieldId}\").parent().show();
            }
        });
    });
    
    function getCities () {
        var region = $(\"#{$regionFieldId} option:selected\").val();
        if (region) {
            $.post(\"/admin/object/get-cities?id=\"+region, function(response) {
                $(\"#{$cityFieldId}\").append(response);
                $(\"#{$cityFieldId}\").val('{$model->city_id}');
            })
            $(\"#{$cityFieldId}\").parent().show();
        }
    }
    
    function checkCityId(attribute, value) {
        return $('#{$localityFieldId} option:selected').val() == {$cityTypeId};
    }
    ") ?>

    <?= $form->field($model, 'locality_type_id', ['options' => ['class' => 'col-lg-3 col-md-6']])->dropDownList($localityType, ['prompt' => 'Выберите населенный пункт']) ?>

    <?= $form->field($model, 'city_id', ['options' => ['class' => 'col-lg-3 col-md-6']])->dropDownList($cities, ['prompt' => 'Выберите город']) ?>

    <?= $form->field($model, 'place_km', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>

    <?= $form->field($model, 'rooms', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>
</div>

<div class="row">
    <?= $form->field($model, 'rate', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'term', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schedule_payments', ['options' => ['class' => 'col-lg-3 col-md-6']])->dropDownList(
        [1 => 'шаровый', 2 => 'аннуитетный'],
        ['prompt' => 'Выберите тип объекта...']
    ) ?>

    <?= $form->field($model, 'nks', ['options' => ['class' => 'col-lg-3 col-md-6']])->textInput() ?>
</div>

<div class="row col-lg-12">
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_map')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagsArray')->checkboxList(
        ArrayHelper::map(Tag::find()->all(), 'id', 'title')
    ) ?>

    <?= $form->field($model, 'confArray')->checkboxList(
        ArrayHelper::map(Confidence::find()->all(), 'id', 'title')
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
    <?php foreach ($listCheckbox as $itemCheckbox) { ?>
        <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>">
            <label><?= $itemCheckbox->title ?></label>
            <div>
                <?php foreach ($itemCheckbox->groupCheckboxes as $itemGroup) { ?>
                    <label class="checkbox">
                        <input type="checkbox"
                               name="GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>][]"
                               value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezCheckbox)) ? 'checked' : '' ?>>
                        <?= $itemGroup->title ?>
                    </label>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<div class="row row-padding">
    <?php foreach ($listRadio as $itemRadio) { ?>
        <div class="form-attribute form-attribute-<?= $itemRadio->type_id ?>">
            <label><?= $itemRadio->title ?></label>
            <?php foreach ($itemRadio->groupRadios as $itemGroup) { ?>
                <label class="radio">
                    <input type="radio" name="GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>][]"
                           value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezRadio)) ? 'checked' : '' ?>>
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

