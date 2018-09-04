<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use kartik\slider\Slider;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content object-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <!-- полная информация об объекте  -->
            <div class="col-lg-12 col-md-12 object-view">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="preview col-lg-4 col-md-12">
                                <?php if (!empty($modelImgs)){ ?>
                                    <div class="preview-pic tab-content">
                                        <?php $count = 1; ?>
                                        <?php foreach ($modelImgs as $item){ ?>
                                            <div class="tab-pane<?php if($count == 1) { echo ' active'; } ?>" id="product_<?= $count; ?>">
                                                <img src="<?= $item->img ?>">
                                            </div>
                                            <?php $count++; ?>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <img class="img-fluid" src="/img/object/no-photo.jpg">
                                <?php } ?>
                                <?php if (!empty($modelImgs)){ ?>
                                    <ul class="preview-thumbnail nav nav-tabs">
                                        <?php $count = 1; ?>
                                        <?php foreach ($modelImgs as $item){ ?>
                                            <li class="nav-item"><a class="nav-link<?php if($count == 1) { echo ' active'; } ?>" data-toggle="tab" href="#product_<?= $count; ?>"><img src="<?= $item->img ?>"></a></li>
                                            <?php $count++; ?>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                            <div class="details col-lg-8 col-md-12">
                                <h3 class="product-title"><?= Html::encode($this->title) ?></h3>
                                <h4 class="price"><span class="col-amber"><?= $model->amount ?> руб.</span></h4>
                                <hr>
                                <p>
                                    <b>Статус:</b>
                                    <?php
                                    switch ($model->status_object){
                                        case 1:
                                            $statusObject = 'сделка частично закрыта';
                                            $classObject = 'label-warning';
                                            break;
                                        case 2:
                                            $statusObject = 'сделка открыта';
                                            $classObject = 'label-success';
                                            break;
                                        default:
                                            $statusObject = 'сделка закрыта';
                                            $classObject = 'label-danger';
                                            break;
                                    }
                                    ?>
                                    <label class="label <?= $classObject ?>"><?= $statusObject ?></label>
                                </p>

                                <!-- доверие объекту -->
                                <p>Доверие объекта составляет <?= $confObj ?>%</p>

                                <!-- шкала -->
                                <div class="object-view">
                                    <div class="object-progress-striped">
                                        <div class="left-pr-striped">0</div>
                                        <div class="center-pr-striped">
                                            <div class="progress progress-striped m-b-5 progress-bar-striped">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $progress['amount-percent'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress['amount-percent'] ?>%" style="">
                                                    <span class="print-amount-striped"><?= $progress['print-amount'] ?>(<?= $progress['amount-percent'] ?>%)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-pr-striped"><?= $model->amount ?></div>
                                    </div>
                                </div>

                                <hr>

                                <div class="action">
                                    <?php if ($userFoll){ ?>
                                        <?= Html::a('Отписаться', ['/catalog/unsubscribe?oId=' . $model->id], ['class' => 'btn btn-primary waves-effect', 'data-confirm' => 'Вы уверены, что хотите отписаться?', 'disable' => true]) ?>
                                    <?php }else{ ?>
                                        <?= Html::button('Откликнуться', ['class' => 'btn btn-default waves-effect', 'data-toggle' => 'modal', 'data-target' => '.bs-example-modal-lg']) ?>
                                    <?php } ?>
                                </div>

                                <!-- вывод информации на подписку -->
                                <?php if ($userFoll){ ?>
                                    <div class="col-lg-12 col-md-12">
                                        <h2>Вы откликнулись на сделку</h2>
                                        <?= $this->render('_listUser', [
                                            'model' => $userFoll
                                        ]);
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- инфо об объекте -->
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'type_id',
                                    'value' => function($model){
                                        $arr = ArrayHelper::map(ObjectType::find()->all(), 'id', 'title');
                                        return $arr[$model->type_id];
                                    }
                                ],
                                'title',
                                'descr:html',
                                'place_km',
                                'amount',
                                'address',
                                'address_map',
                                'area',
                                'rooms',
                                'owner',
                                'price_cadastral',
                                'price_tian',
                                'price_market',
                                'price_liquidation',
                                'rate',
                                'term',
                                [
                                    'attribute' => 'schedule_payments',
                                    'value' => function($model){
                                        return ($model->schedule_payments === 1)?'шаровый':'аннуитетный';
                                    }
                                ],
                                'nks',
                            ],
                        ]) ?>

                        <!-- файлы -->
                        <?php if (!empty($modelFiles)){ ?>
                            <h2 class="card-inside-title">Документы</h2>
                            <?php foreach ($modelFiles as $item){ ?>
                                <div>
                                    <a href="<?= $item->doc ?>"><?= $item->title ?></a>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <!-- комментарии -->
                        <h2 class="card-inside-title">Комментарии</h2>
                        <?= $this->render('_comments', [
                            'commentNew' => $commentNew,
                            'oId' => $model->id,
                            'commentList' => $commentList
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $formCheckbox = ActiveForm::begin(); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Добавить новый элемент</h4>
            </div>
            <div class="modal-body modal-checkbox">

                <?= $formCheckbox->field($userRoom, 'sum')->textInput() ?>

                <div>
                    <input id="user-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="0"
                        data-slider-max="<?= $model->amount ?>"
                        data-slider-step="1"
                        data-slider-value="<?= $model->amount ?>"
                        />
                </div>
                <br>
                <div>
                    <?= $formCheckbox->field($userRoom, 'object_id')->hiddenInput(['value'=> $model->id])->label(false);?>

                    <?= $formCheckbox->field($userRoom, 'user_id')->hiddenInput(['value'=> Yii::$app->user->id])->label(false); ?>

                    <?= $formCheckbox->field($userRoom, 'rate')->textInput() ?>

                    <?= $formCheckbox->field($userRoom, 'term')->textInput() ?>

                    <?= $formCheckbox->field($userRoom, 'schedule_payments')->dropDownList(
                        [1 => 'шаровый', 2 => 'аннуитетный']
                    ) ?>

                    <?= $formCheckbox->field($userRoom, 'comment')->textarea() ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

