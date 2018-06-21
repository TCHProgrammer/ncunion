<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model frontend\models\ObjectSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $filterPassport object*/
/* @var $filter array */
/* @var $listCheckboxes common\models\object\AttributeCheckbox */
/* @var $listRadios common\models\object\AttributeRadio*/

function valueFilter($item, $filter){
    return (!empty($_GET['ObjectSearch'][$item])) ? $_GET['ObjectSearch'][$item] : $filter['ObjectSearch'][$item];
}
?>

<div class="object-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <?= $form->field($model, 'title', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

        <?= $form->field($model, 'type_id',
            [
                'options' => ['class' => 'input-adjustment col-lg-3 col-md-3'],
                'inputOptions' => ['class' => 'form-control']
            ])->dropDownList(
                ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                ['prompt' => 'Выберите тип объекта...']
            ) ?>

        <?= $form->field($model, 'place_km', ['options' => ['class' => 'input-adjustment col-lg-3 col-md-3']])->dropDownList(
            [
                0 => 'Москва',
                10 => 'до 10 км от МКАД',
                25 => 'до 25 км от МКАД',
                50 => 'до 50 км от МКАД',
                100 => 'до 100 км от МКАД',
            ],
            ['prompt' => 'Выберите удалённость от Москвы...']
        ) ?>

    </div>

    <div id="filter-slider" class="row">
        <!-- цена -->
        <div class="col-lg-4">
            <?= $form->field($model, 'amount_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']])->textInput(['data-value' => $filterPassport->amount_min]) ?>

            <?= $form->field($model, 'amount_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']])->textInput(['data-value' => $filterPassport->amount_max]) ?>

            <div class="col-lg-12">
                <input id="price-slider"
                    data-slider-id='ex1Slider'
                    type="text"
                    data-slider-min="<?= $filter['ObjectSearch']['amount_min'] ?>"
                    data-slider-max="<?= $filter['ObjectSearch']['amount_max'] ?>"
                    data-slider-step="1"
                    data-slider-value="[<?= valueFilter('amount_min', $filter) ?>, <?= valueFilter('amount_max', $filter) ?>]"
                />
            </div>
        </div>

        <!-- площадь -->
        <div class="col-lg-4">
            <?= $form->field($model, 'area_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']])->textInput(['data-value' => $filterPassport->area_min]) ?>

            <?= $form->field($model, 'area_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']])->textInput(['data-value' => $filterPassport->area_max]) ?>

            <div class="col-lg-12">
                <input id="area-slider"
                    data-slider-id='ex1Slider'
                    type="text"
                    data-slider-min="<?= $filter['ObjectSearch']['area_min'] ?>"
                    data-slider-max="<?= $filter['ObjectSearch']['area_max'] ?>"
                    data-slider-step="1"
                    data-slider-value="[<?= valueFilter('area_min', $filter) ?>, <?= valueFilter('area_max', $filter)?>]"
                />
            </div>
        </div>

        <!-- комнаты -->
        <div class="col-lg-4">
            <?= $form->field($model, 'rooms_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']])->textInput(['data-value' => $filterPassport->rooms_min]) ?>

            <?= $form->field($model, 'rooms_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']])->textInput(['data-value' => $filterPassport->rooms_max]) ?>

            <div class="col-lg-12">
                <input id="rooms-slider"
                    data-slider-id='ex1Slider'
                    type="text"
                    data-slider-min="<?= $filter['ObjectSearch']['rooms_min'] ?>"
                    data-slider-max="<?= $filter['ObjectSearch']['rooms_max'] ?>"
                    data-slider-step="1"
                    data-slider-value="[<?= valueFilter('rooms_min', $filter) ?>, <?= valueFilter('rooms_max', $filter) ?>]"
                />
            </div>
        </div>
    </div>

    <div class="row">
        <?= $form->field($model, 'price_cadastral', ['options' => ['class' => 'input-adjustment col-lg-3 col-md-3']]) ?>

        <?= $form->field($model, 'price_tian', ['options' => ['class' => 'input-adjustment col-lg-3 col-md-3']]) ?>

        <?= $form->field($model, 'price_market', ['options' => ['class' => 'input-adjustment col-lg-3 col-md-3']]) ?>

        <?= $form->field($model, 'price_liquidation', ['options' => ['class' => 'input-adjustment col-lg-3 col-md-3']]) ?>
    </div>

    <?php //var_dump($_GET); ?>

    <?php foreach ($listCheckboxes as $itemCheckbox){ ?>
        <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>" style="<?= ($itemCheckbox->type_id == $model->type_id)?'display: block':'display: none' ?>">
            <label><?= $itemCheckbox->title ?></label>
            <div>
                <?php foreach ($itemCheckbox->groupCheckboxes as $itemGroup){ ?>
                    <label class="checkbox">
                        <input type="checkbox"
                               id="filter-checkbox"
                               name="GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>][]"
                               value="<?= $itemGroup->id ?>"
                               <?= (in_array($itemGroup->id, $rezCheckboxes))?'checked':'' ?>
                               <?php if (isset($arrFilterPassport['checkboxs'][$itemCheckbox->id])){ ?>
                                   <?= (in_array($itemGroup->id, $arrFilterPassport['checkboxs'][$itemCheckbox->id]))?'data-value=1':'' ?>
                               <?php } ?>>
                        <?= $itemGroup->title ?>
                    </label>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <?php foreach ($listRadios as $itemRadio){ ?>
            <div class="form-attribute form-attribute-<?= $itemRadio->type_id ?>"  style="<?= ($itemRadio->type_id == $model->type_id)?'display: block':'display: none' ?>">
                <label><?= $itemRadio->title ?></label>
                <?php foreach ($itemRadio->groupRadios as $itemGroup){ ?>
                    <label class="radio">
                        <input type="radio"
                               name="GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>][]"
                               value="<?= $itemGroup->id ?>"
                               <?= (in_array($itemGroup->id, $rezRadios))?'checked':'' ?>
                               <?php if (isset($arrFilterPassport['radios'][$itemRadio->id])){ ?>
                                   <?= (in_array($itemGroup->id, $arrFilterPassport['radios'][$itemRadio->id]))?'data-value=1':'' ?>
                               <?php } ?>>
                        <?= $itemGroup->title ?>
                    </label>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить фильтр', ['/catalog'], ['class' => 'btn btn-default']) ?>
        <?= Html::button('Применить фильтр из паспорта', ['class' => 'btn btn-default', 'id' => 'filter-passport']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
