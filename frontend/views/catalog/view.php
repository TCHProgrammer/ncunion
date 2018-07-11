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

<div class="row">

    <!-- полная информация об объекте  -->
    <div class="col-lg-12 col-md-12 object-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php if ($userFoll){ ?>
            <p><?= Html::a('Отписаться', ['/catalog/unsubscribe?oId=' . $model->id], ['class' => 'btn btn-primary', 'data-confirm' => 'Вы уверены, что хотите отписаться?', 'disable' => true]) ?></p>
        <?php }else{ ?>
            <p><?= Html::button('Откликнуться', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '.bs-example-modal-lg']) ?></p>
        <?php } ?>

        <p>
            Статус:
            <?php
                switch ($model->status_object){
                    case 1:
                        $statusObject = 'сделка частично закрыта';
                        $classObject = 'btn-warning';
                        break;
                    case 2:
                        $statusObject = 'сделка открыта';
                        $classObject = 'btn-success';
                        break;
                    default:
                        $statusObject = 'сделка закрыта';
                        $classObject = 'btn-danger';
                        break;
                }
            ?>
            <span class="<?= $classObject ?>"><?= $statusObject ?></span>
        </p>

        <!-- доверие объекту -->
        <p>Доверие объекта составяент <?= $confObj ?>%</p>

        <!-- шкала -->
        <div class="object-view col-lg-6 col-md-6">
            <div class="object-progress-striped">
                <div class="left-pr-striped">0</div>
                <div class="center-pr-striped">
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $progress['amount-percent'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress['amount-percent'] ?>%">
                            <span class="print-amount-striped"><?= $progress['print-amount'] ?>(<?= $progress['amount-percent'] ?>%)</span>
                        </div>
                    </div>
                </div>
                <div class="right-pr-striped"><?= $model->amount ?></div>
            </div>
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
    </div>

    <!-- фото -->
    <?php if (!empty($modelImgs)){ ?>
        <div class="col-lg-12 col-md-12">
            <h3>Фотогалерея</h3>
            <hr>
            <?php foreach ($modelImgs as $item){ ?>
                <img src="<?= $item->img ?>" style="width: 200px">
            <?php } ?>
        </div>
    <?php } ?>

    <!-- файлы -->
    <?php if (!empty($modelFiles)){ ?>
        <div class="col-lg-12 col-md-12">
            <h3>Документы</h3>
            <hr>
            <?php foreach ($modelFiles as $item){ ?>
                <div>
                    <a href="<?= $item->doc ?>"><?= $item->title ?></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <!-- комментарии -->
    <div class="col-lg-12 col-md-12">
        <h3>Комментарии</h3>
        <?= $this->render('_comments', [
            'commentNew' => $commentNew,
            'oId' => $model->id,
            'commentList' => $commentList
        ]); ?>
    </div>

</div>

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

