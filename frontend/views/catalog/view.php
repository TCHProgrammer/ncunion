<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="object-view col-lg-6 col-md-6">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php if ($userFoll){ ?>
            <?php if ($finishObject){ ?>
                <p><?= Html::a('Отписаться', ['/catalog/unsubscribe?oId=' . $model->id], ['class' => 'btn btn-primary', 'data-confirm' => 'Вы уверены, что хотите отписаться?', 'disable' => true]) ?></p>
            <?php }else{ ?>
                <p class="btn-success">Вы успешно получили данный объект!</p>
            <?php } ?>
        <?php }else{ ?>
            <p><?= Html::button('Откликнуться', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '.bs-example-modal-lg']) ?></p>
        <?php } ?>

        <p>Статус:
        <?php
        switch ($model->status_object){
            case 1:
                echo '<span class="btn-warning">сделка частично закрыта</span>';
                break;
            case 2:
                echo '<span class="btn-success">сделка открыта</span>';
                break;
            default:
                echo '<span class="btn-danger">сделка закрыта</span>';
                break;
        }
        ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'type_id',
                'title',
                'descr:ntext',
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
                'status_object',
                'sticker_id',
            ],
        ]) ?>

    </div>

    <div class="users col-lg-6 col-md-6">
        <?php if (Yii::$app->user->can('btn_give_investor')) { ?>
            <?= $this->render('_userList', [
                'usersObjectlist' => $usersObjectlist,
                'finishObject' => $finishObject
            ]); ?>
        <?php }else{ ?>
            <?= $this->render('_comments'); ?>
        <?php } ?>
    </div>

    <div class="col-lg-12 col-md-12">
        <?php if (Yii::$app->user->can('btn_give_investor')) { ?>
            <?= $this->render('_comments', [
                'commentNew' => $commentNew,
                'oId' => $model->id,
                'dataProvider' => $commentList
            ]); ?>
        <?php } ?>
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
                <?= $formCheckbox->field($userRoom, 'object_id')->hiddenInput(['value'=> $model->id])->label(false);?>

                <?= $formCheckbox->field($userRoom, 'user_id')->hiddenInput(['value'=> Yii::$app->user->id])->label(false); ?>

                <?= $formCheckbox->field($userRoom, 'sum')->textInput() ?>

                <?= $formCheckbox->field($userRoom, 'rate')->textInput() ?>

                <?= $formCheckbox->field($userRoom, 'consumption')->textInput() ?>

                <?= $formCheckbox->field($userRoom, 'comment')->textarea() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

