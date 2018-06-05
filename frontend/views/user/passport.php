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

        <div class="row">
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
        </div>

        <div class="row row-padding">
            <?php foreach ($listValue as $itemValue){ ?>
                <div class="form-attribute form-attribute-<?= $itemValue->type_id ?>" style="<?= ($itemValue->type_id == $model->type_id)?'display: block':'display: none' ?>">
                    <label><?= $itemValue->title ?></label>
                    <div>
                        <input type="text" class="form-control" name="GroupValue[<?= $itemValue->type_id ?>][<?= $itemValue->id ?>][]" value="<?= $rezValue[$itemValue->id] ?>">
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="row row-padding">
            <?php foreach ($listCheckbox as $itemCheckbox){ ?>
                <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>" style="<?= ($itemCheckbox->type_id == $model->type_id)?'display: block':'display: none' ?>">
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
                <div class="form-attribute form-attribute-<?= $itemRadio->type_id ?>" style="<?= ($itemRadio->type_id == $model->type_id)?'display: block':'display: none' ?>">
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

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'form_participation_id', ['options' => ['class' => 'radio-form']])->radioList(ArrayHelper::map(FormParticipation::find()->all(), 'id', 'title')) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
