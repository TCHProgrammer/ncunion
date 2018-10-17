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
                    <div id="filter-slider">
                        <div class="row clearfix search-filters">
                            <div class="col-lg-4 col-md-6 col-sm-12 hide">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?= $form->field($model, 'title', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group select-group">
                                    <?= $form->field($model, 'type_id',
                                        [
                                            'options' => ['class' => 'input-adjustment input-adjustment-dropdown'],
                                            'inputOptions' => ['class' => 'form-control', 'data-style' => 'btn-default']
                                        ])->dropDownList(
                                        ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                                        ['prompt' => 'Тип объекта...']
                                    ) ?>

                                    <?= $form->field($model, 'place_km', [
                                        'options' => ['class' => 'input-adjustment input-adjustment-dropdown'],
                                    ])->dropDownList(
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
                                <div class="form-group inputs-group">
                                    <span class="inputs-group-label">Метраж:</span>
                                    <div class="inputs-group-stack">
                                        <?= $form->field($model, 'area_min', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->area_min, 'placeholder' => 'от']) ?><?= $form->field($model, 'area_max', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->area_max, 'placeholder' => 'до']) ?>
                                    </div>
                                </div>
                                <div class="form-group inputs-group search-filters-price">
                                    <span class="inputs-group-label">Цена:</span>
                                    <div class="inputs-group-stack">
                                        <?= $form->field($model, 'amount_min', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->amount_min, 'placeholder' => 'от']) ?><?= $form->field($model, 'amount_max', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->amount_max, 'placeholder' => 'до']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal -->
                        <div class="modal fade modal-md" id="more-filters-modal" tabindex="-1" role="dialog" aria-labelledby="more-filters-modal-heading">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="more-filters-modal-heading">Расширенный поиск</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div id="more-filters" class="row clearfix search-filters">

                                            <div class="col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="form-group inputs-group">
                                                        <div class="col-sm-4">
                                                            <span class="inputs-group-label">Комнаты:</span>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="inputs-group-stack">
                                                                <?= $form->field($model, 'rooms_min', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->rooms_min, 'placeholder' => 'от']) ?><?= $form->field($model, 'rooms_max', ['options' => ['class' => 'input-adjustment form-line']])->textInput(['data-value' => $filterPassport->rooms_max, 'placeholder' => 'до']) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group inputs-group input-individual">
                                                        <div class="col-sm-4">
                                                            <span class="inputs-group-label">Кадастровая стоимость:</span>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="inputs-group-stack">
                                                                <?= $form->field($model, 'price_cadastral', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group inputs-group input-individual">
                                                        <div class="col-sm-4">
                                                            <span class="inputs-group-label">ЦИАН:</span>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="inputs-group-stack">
                                                                <?= $form->field($model, 'price_tian', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group inputs-group input-individual">
                                                        <div class="col-sm-4">
                                                            <span class="inputs-group-label">Рыночная стоимость:</span>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="inputs-group-stack">
                                                                <?= $form->field($model, 'price_market', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group inputs-group input-individual">
                                                        <div class="col-sm-4">
                                                            <span class="inputs-group-label">Ликвидационная стоимость:</span>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="inputs-group-stack">
                                                                <?= $form->field($model, 'price_liquidation', ['options' => ['class' => 'input-adjustment form-line']]) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <?php foreach ($listCheckboxes as $itemCheckbox){ ?>
                                                        <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>" style="<?= ($itemCheckbox->type_id == $model->type_id)?'display: block':'display: none' ?>">

                                                            <div class="col-sm-4">
                                                                <b><?= $itemCheckbox->title ?></b>
                                                            </div>

                                                            <div class="col-sm-8">
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

                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group">
                                            <?php // TODO: Не думаю, что два submit-инпута, делающие одинаковые вещи в одной и той же форме - правильное решение. ?>
                                            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="row clearfix search-filters">
                            <div class="col-sm-12">
                                <div class="form-group buttons">
                                    <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                                    <?= Html::button('Еще фильтры', ['class' => 'btn btn-filter', 'id' => 'more-filters-button', 'data-toggle' => 'modal', 'data-target' => '#more-filters-modal']) ?>
                                    <?= Html::a('Сбросить фильтр', ['/catalog'], ['class' => 'btn btn-filter']) ?>
                                    <?= Html::button('Применить фильтр из паспорта', ['class' => 'btn btn-filter', 'id' => 'filter-passport']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
