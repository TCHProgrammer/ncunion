<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\object\ObjectType;
use common\models\passport\FormParticipation;

$this->title="Паспорт клиента";

function valuePassport($item, $filter, $model){
    return (!empty($model->$item)) ? $model->$item : $filter['ObjectSearch'][$item];
}
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="object-form">
    <div class="row">

        <?php $form = ActiveForm::begin(); ?>

        <!-- ползунки -->
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'amount_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <?= $form->field($model, 'amount_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <div class="col-lg-12">
                    <input id="price-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="<?= $filter['ObjectSearch']['amount_min'] ?>"
                        data-slider-max="<?= $filter['ObjectSearch']['amount_max'] ?>"
                        data-slider-step="1"
                        data-slider-value="[<?= valuePassport('amount_min', $filter, $model) ?>, <?= valuePassport('amount_max', $filter, $model) ?>]"
                    />
                </div>
            </div>

            <div class="col-lg-4">
                <?= $form->field($model, 'area_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <?= $form->field($model, 'area_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <div class="col-lg-12">
                    <input id="area-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="<?= $filter['ObjectSearch']['area_min'] ?>"
                        data-slider-max="<?= $filter['ObjectSearch']['area_max'] ?>"
                        data-slider-step="1"
                        data-slider-value="[<?= valuePassport('area_min', $filter, $model) ?>, <?= valuePassport('area_max', $filter, $model)?>]"
                    />
                </div>
            </div>

            <div class="col-lg-4">
                <?= $form->field($model, 'rooms_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <?= $form->field($model, 'rooms_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <div class="col-lg-12">
                    <input id="rooms-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="<?= $filter['ObjectSearch']['rooms_min'] ?>"
                        data-slider-max="<?= $filter['ObjectSearch']['rooms_max'] ?>"
                        data-slider-step="1"
                        data-slider-value="[<?= valuePassport('rooms_min', $filter, $model) ?>, <?= valuePassport('rooms_max', $filter, $model) ?>]"
                    />
                </div>
            </div>
        </div>

        <!-- типы объектов -->
        <div class="row">

            <ul class="nav nav-tabs" id="myTabEvents">
                <?php foreach ($objectTypeList as $id => $title){?>
                    <li <?= ($id == 1) ? 'class="active"' : '' ?>>
                        <a class="tabnav" data-toggle="tab" href="#panel-type-<?= $id ?>"><?= $title ?></a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content" id="myTabContent">
                <?php foreach ($objectTypeList as $id => $title){?>
                    <div id="panel-type-<?= $id ?>" class="tab-pane fade <?= ($id == 1) ? 'in active' : '' ?>">
                        <br>
                        <!-- группа строк -->
                        <!--<div>
                            <php foreach ($listValue as $itemValue){ ?>
                                <php if ($itemValue->type_id == $id){ ?>
                                    <label><= $itemValue->title ?></label>
                                    <div>
                                        <input type="text" class="form-control" name="GroupValue[<= $itemValue->type_id ?>][<= $itemValue->id ?>][]" value="<= isset($rezValue[$itemValue->id])?$rezValue[$itemValue->id]:'' ?>">
                                    </div>
                                <php }else{continue;} ?>
                            <php } ?>
                        </div>-->

                        <!-- группа четбоксов -->
                        <div>
                            <?php foreach ($listCheckbox as $itemCheckbox){ ?>
                                <?php if ($itemCheckbox->type_id == $id){ ?>
                                    <label><?= $itemCheckbox->title ?></label>
                                    <div>
                                        <?php foreach ($itemCheckbox->groupCheckboxes as $itemGroup){ ?>
                                            <label class="checkbox">
                                                <input type="checkbox" name="GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>][]" value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezCheckbox))?'checked':'' ?>>
                                                <?= $itemGroup->title ?>
                                            </label>
                                            <?php } ?>
                                        </div>
                                <?php }else{continue;} ?>
                            <?php } ?>
                        </div>

                        <!-- группа радио кнопок -->
                        <div>
                            <?php foreach ($listRadio as $itemRadio){ ?>
                                <?php if ($itemRadio->type_id == $id){ ?>
                                    <label><?= $itemRadio->title ?></label>
                                    <?php foreach ($itemRadio->groupRadios as $itemGroup){ ?>
                                        <label class="radio">
                                            <input type="radio" name="GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>][]" value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezRadio))?'checked':'' ?>>
                                            <?= $itemGroup->title ?>
                                        </label>
                                        <?php } ?>
                                <?php }else{continue;} ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <hr>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'tagsArray', ['options' => ['class' => 'radio-form']])->checkboxList(
                    ArrayHelper::map(FormParticipation::find()->all(), 'id', 'title')
                )?>
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
