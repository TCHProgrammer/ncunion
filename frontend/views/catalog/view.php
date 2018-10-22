<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\ListView;
use kartik\slider\Slider;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;
use common\models\object\Confidence;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */
/* @var $listViewCheckboxes frontend\controllers\CatalogController */
/* @var $objectGroupCheckboxes frontend\controllers\CatalogController */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content object-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <?= Breadcrumbs::widget([
                    'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix" id="object-wrapper">
            <!-- полная информация об объекте  -->
            <div class="col-lg-8 col-md-8 object-center" id="object-center">
                <div class="card">
                    <div class="body">
                        <div class="row" id="object-wrapper-top">
                            <div class="preview col-lg-7 col-md-12">
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
                            <div class="details col-lg-5 col-md-12">
                                <h3 class="product-title">
                                    <?php // TODO: Пофиксить запятые. ?>
                                    <?= $model->typeTitle . ', '?>
                                    <?php if(!is_null($model->rooms)) { ?>
                                        <?= $model->rooms . ' комн.,' ?>
                                    <?php } ?>
                                    <?php if(!is_null($model->area)) { ?>
                                        <?= $model->area . ' м²' ?>
                                    <?php } ?>
                                </h3>
                                <div class="object-info-inline">
                                    <h4>Статус</h4>
                                    <?php
                                    switch ($model->status_object){
                                        case 1:
                                            $statusObject = 'Сделка частично закрыта';
                                            $classObject = 'label-warning';
                                            break;
                                        case 2:
                                            $statusObject = 'Сделка открыта';
                                            $classObject = 'label-success';
                                            break;
                                        default:
                                            $statusObject = 'Сделка закрыта';
                                            $classObject = 'label-danger';
                                            break;
                                    }
                                    ?>
                                    <label class="label <?= $classObject ?>"><?= $statusObject ?></label>
                                </div>

                                <!-- доверие объекту -->
                                <div class="object-info-inline object-trust">
                                    <h4>Индекс доверия<span class="mini-info" data-toggle="tooltip" data-placement="top" title="Индекс доверия">?</span></h4>
                                    <input type="text" class="trust_o_meter" readonly="readonly" value="<?= $confObj ?>" data-width="36" data-height="36" data-thickness="0.2" data-fgColor="#FF1601" data-bgColor="#B9B9B9" disabled>
                                </div>
                                <?php $confidenceArray = Confidence::find()->all(); ?>
                                <?php if (!is_null($confidenceArray)) { ?>
                                <div class="object-info-inline object-trust-docs">
                                    <?php
                                    foreach ($confidenceArray as $confidenceItem) {
                                        if (in_array($confidenceItem->id, $model->confArray)) {
                                            $confidenceItemClass = ' checked';
                                        } else {
                                            $confidenceItemClass = '';
                                        }
                                    ?>
                                    <div class="item<?= $confidenceItemClass; ?>">
                                        <span class="zmdi-hc-stack zmdi-hc-lg">
                                            <i class="zmdi zmdi-square-o zmdi-hc-stack-2x"></i>
                                            <i class="zmdi zmdi-check zmdi-hc-stack-1x"></i>
                                        </span>
                                        <span class="value"><?= $confidenceItem->title; ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <h4>Общая информация</h4>

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
                                        'rooms',
                                        'area',
                                        'place_km',
                                        'descr:html',
                                    ],
                                    'options' => [
                                        'class' => 'table table-bordered detail-view'
                                    ]
                                ]) ?>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <?php echo '<pre>', print_r($objectGroupCheckboxes), '</pre>'; ?>
                            </div>
                        </div>
                        <div class="row" id="object-wrapper-bottom">
                            <div class="docs-other col-lg-7 col-md-12">
                                <!-- файлы -->
                                <?php if (!empty($modelFiles)){ ?>
                                    <h4>Документы</h4>
                                    <?php foreach ($modelFiles as $item){ ?>
                                        <div>
                                            <a href="<?= $item->doc ?>"><?= $item->title ?></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                                <div class="row clearfix">
                                <?php
                                foreach ($listViewCheckboxes as $listViewCheckbox) {
                                    $item = ArrayHelper::toArray($listViewCheckbox, [
                                        'common\models\object\AttributeCheckbox' => [
                                            'attributes',
                                            'groupCheckboxes'
                                        ],
                                    ]);
                                    $itemAttributes = $item['attributes'];
                                    $itemGroupCheckboxes = $item['groupCheckboxes'];
                                ?>
                                    <div class="col-sm-6">
                                        <h4><?= $itemAttributes['title']; ?></h4>
                                        <table class="table table-bordered detail-view">
                                            <tbody>
                                            <?php
                                            foreach ($itemGroupCheckboxes as $itemGroupCheckbox) {
                                            ?>
                                                <tr>
                                                    <th><?= $itemGroupCheckbox['title']; ?></th>
                                                    <?php
                                                    if(ArrayHelper::isIn($itemGroupCheckbox['id'], $objectGroupCheckboxes)) {
                                                    ?>
                                                        <td class="true">Да</td>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td class="false">Нет</td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                }
                                ?>
                                </div>
                            </div>
                        </div>

                        <!-- вывод информации на подписку -->
                        <?php if ($userFoll){ ?>
                        <div class="profile-page row clearfix">
                            <div class="col-sm-12">
                                <h2 class="card-inside-title">Вы откликнулись на сделку</h2>
                            </div>
                            <div class="col-sm-12">
                                <div class="card overflowhidden m-t-20">
                                    <?= $this->render('_listUser', [
                                        'model' => $userFoll
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 object-side" id="object-side">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="details col-sm-12">
                                <h4 class="price"><?= $model->amount ?> &#8381;</h4>
                                <span class="product_help">Требуемая сумма</span>

                                <!-- шкала -->
                                <h4>Собранные средства</h4>
                                <div class="object-view">
                                    <div class="object-progress-striped">
                                        <div class="left-pr-striped">0 &#8381;</div>
                                        <div class="center-pr-striped">
                                            <div class="progress progress-striped m-b-5 progress-bar-striped">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $progress['amount-percent'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress['amount-percent'] ?>%" style="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-pr-striped"><?= $model->amount ?> &#8381;</div>
                                    </div>
                                </div>

                                <!-- инфо об объекте -->
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'price_cadastral',
                                        'price_tian',
                                        'price_market',
                                        'price_liquidation',
                                        'nks',
                                    ],
                                    'options' => [
                                        'class' => 'table table-bordered detail-view'
                                    ]
                                ]) ?>

                                <h4>Пожелания к кредиту</h4>
                                <!-- инфо об объекте -->
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'attribute' => 'schedule_payments',
                                            'value' => function($model){
                                                return ($model->schedule_payments === 1)?'шаровый':'аннуитетный';
                                            }
                                        ],
                                        'rate',
                                        'term',
                                    ],
                                    'options' => [
                                        'class' => 'table table-bordered detail-view credit-wishes'
                                    ]
                                ]) ?>

                                <div class="action">
                                    <?php if ($userFoll){ ?>
                                        <?= Html::a('Отписаться', ['/catalog/unsubscribe?oId=' . $model->id], ['class' => 'btn btn-primary btn-respond waves-effect', 'data-confirm' => 'Вы уверены, что хотите отписаться?', 'disable' => true]) ?>
                                    <?php }else{ ?>
                                        <?= Html::button('Откликнуться', ['class' => 'btn btn-primary btn-respond waves-effect', 'data-toggle' => 'modal', 'data-target' => '.bs-example-modal-lg']) ?>
                                    <?php } ?>
                                </div>
                                <div class="scroll-to-comment">
                                    <?= Html::button('Оставить комментарий', ['class' => 'btn btn-scrollto waves-effect', 'id' => 'scroll-to-comment-button']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 object-map">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="object-map col-sm-12">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="address">
                                            <!-- инфо об объекте -->
                                            <?= DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    'address',
                                                ],
                                                'options' => [
                                                    'class' => 'table table-bordered detail-view object-address'
                                                ]
                                            ]) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d834.0627836242512!2d87.1120109877622!3d53.752355267470826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42d0c0fa0b6ec60b%3A0xcb4c0588da4e255c!2z0KDQsNC00LjQvtGC0LXRhdC90LjQutCw!5e0!3m2!1sru!2sru!4v1539262302918" frameborder="0" style="width: 100%; height: 600px; border:0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 object-comments">
                <div class="card">
                    <div class="body">

                        <!-- комментарии -->
                        <h4>Комментарии</h4>
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

                <div class="form-group">
                    <?= $formCheckbox->field($userRoom, 'sum', ['options' => ['class' => 'form-line']])->textInput(['value' => '']) ?>
                </div>

                <div>
                    <input id="user-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-min="0"
                        data-max="<?= $model->amount ?>"
                        data-step="1"
                        />
                </div>
                <br>
                <div>
                    <?= $formCheckbox->field($userRoom, 'object_id', ['options' => ['class' => 'form-block']])->hiddenInput(['value'=> $model->id])->label(false);?>

                    <?= $formCheckbox->field($userRoom, 'user_id', ['options' => ['class' => 'form-block']])->hiddenInput(['value'=> Yii::$app->user->id])->label(false); ?>

                    <div class="form-group">
                        <?= $formCheckbox->field($userRoom, 'rate', ['options' => ['class' => 'form-line']])->textInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $formCheckbox->field($userRoom, 'term', ['options' => ['class' => 'form-line']])->textInput() ?>
                    </div>

                    <?= $formCheckbox->field($userRoom, 'schedule_payments')->dropDownList(
                        [1 => 'шаровый', 2 => 'аннуитетный']
                    ) ?>
                    <div class="form-group">
                        <?= $formCheckbox->field($userRoom, 'comment', ['options' => ['class' => 'form-line']])->textarea() ?>
                    </div>
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

