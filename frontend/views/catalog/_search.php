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

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 hide">
                            <div class="form-group">
                                <div class="form-line">
                                    <?= $form->field($model, 'title', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="form-group select-group">
                                    <?= $form->field($model, 'type_id',
                                        [
                                            'options' => ['class' => 'input-adjustment input-adjustment-dropdown'],
                                            'inputOptions' => ['class' => 'form-control']
                                        ])->dropDownList(
                                        ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                                        ['prompt' => 'Тип объекта...']
                                    ) ?>

                                    <?= $form->field($model, 'place_km', ['options' => ['class' => 'input-adjustment input-adjustment-dropdown']])->dropDownList(
                                        [
                                            0 => 'Москва',
                                            10 => 'до 10 км от МКАД',
                                            25 => 'до 25 км от МКАД',
                                            50 => 'до 50 км от МКАД',
                                            100 => 'до 100 км от МКАД',
                                        ],
                                        ['prompt' => 'Место...']
                                    ) ?>
                            </div>
                        </div>
                    </div>
                    <div id="filter-slider" class="row clearfix">
                        <!-- цена -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'amount_min', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->amount_min]) ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'amount_max', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->amount_max]) ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <input id="price-slider-catalog"
                                           data-slider-id='ex1Slider'
                                           type="text"
                                           data-type="double"
                                           data-min="<?= $filter['ObjectSearch']['amount_min'] ?>"
                                           data-max="<?= $filter['ObjectSearch']['amount_max'] ?>"
                                           data-from="<?= valueFilter('amount_min', $filter, $model) ?>"
                                           data-to="<?= valueFilter('amount_max', $filter, $model) ?>"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- площадь -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'area_min', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->area_min]) ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'area_max', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->area_max]) ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <input id="area-slider-catalog"
                                           data-slider-id='ex1Slider'
                                           type="text"
                                           data-type="double"
                                           data-min="<?= $filter['ObjectSearch']['area_min'] ?>"
                                           data-max="<?= $filter['ObjectSearch']['area_max'] ?>"
                                           data-from="<?= valueFilter('area_min', $filter, $model) ?>"
                                           data-to="<?= valueFilter('area_max', $filter, $model) ?>"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- комнаты -->
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'rooms_min', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->rooms_min]) ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'rooms_max', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->rooms_max]) ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <input id="rooms-slider-catalog"
                                           data-slider-id='ex1Slider'
                                           type="text"
                                           data-type="double"
                                           data-min="<?= $filter['ObjectSearch']['rooms_min'] ?>"
                                           data-max="<?= $filter['ObjectSearch']['rooms_max'] ?>"
                                           data-from="<?= valueFilter('rooms_min', $filter, $model) ?>"
                                           data-to="<?= valueFilter('rooms_max', $filter, $model) ?>"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <?= $form->field($model, 'price_cadastral', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <?= $form->field($model, 'price_tian', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <?= $form->field($model, 'price_market', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <?= $form->field($model, 'price_liquidation', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <?php //var_dump($_GET); ?>

                        <div class="col-sm-12">
                            <?php foreach ($listCheckboxes as $itemCheckbox){ ?>
                                <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>" style="<?= ($itemCheckbox->type_id == $model->type_id)?'display: block':'display: none' ?>">
                                    <b><?= $itemCheckbox->title ?></b>
                                    <div>
                                        <?php foreach ($itemCheckbox->groupCheckboxes as $itemGroup){ ?>
                                            <input
                                                type="checkbox"
                                                id="filter-checkboxes-GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>]-<?= $itemGroup->id ?>"
                                                name="GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>][]"
                                                value="<?= $itemGroup->id ?>"
                                                <?= (in_array($itemGroup->id, $rezCheckboxes))?'checked':'' ?>
                                                <?php if (isset($arrFilterPassport['checkboxs'][$itemCheckbox->id])){ ?>
                                                    <?= (in_array($itemGroup->id, $arrFilterPassport['checkboxs'][$itemCheckbox->id]))?'data-value=1':'' ?>
                                                <?php } ?>
                                            >
                                            <label class="checkbox" for="filter-checkboxes-GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>]-<?= $itemGroup->id ?>">
                                                <?= $itemGroup->title ?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <?php foreach ($listRadios as $itemRadio){ ?>
                                <div class="form-attribute form-attribute-<?= $itemRadio->type_id ?>"  style="<?= ($itemRadio->type_id == $model->type_id)?'display: block':'display: none' ?>">
                                    <b><?= $itemRadio->title ?></b>
                                    <?php foreach ($itemRadio->groupRadios as $itemGroup){ ?>
                                        <input
                                                type="radio"
                                                id="filter-radios-GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>]-<?= $itemGroup->id ?>"
                                                name="GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>][]"
                                                value="<?= $itemGroup->id ?>"
                                            <?= (in_array($itemGroup->id, $rezRadios))?'checked':'' ?>
                                            <?php if (isset($arrFilterPassport['radios'][$itemRadio->id])){ ?>
                                                <?= (in_array($itemGroup->id, $arrFilterPassport['radios'][$itemRadio->id]))?'data-value=1':'' ?>
                                            <?php } ?>
                                        >
                                        <label class="radio" for="filter-radios-GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>]-<?= $itemGroup->id ?>">
                                            <?= $itemGroup->title ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Сбросить фильтр', ['/catalog'], ['class' => 'btn btn-default']) ?>
                                <?= Html::button('Применить фильтр из паспорта', ['class' => 'btn btn-default', 'id' => 'filter-passport']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
