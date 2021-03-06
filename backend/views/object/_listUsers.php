<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var $objectAmount
 * @var @finishObject
 */

$progress['print-amount'] = $model->sum;
if ((int)$objectAmount > $model->sum) {
    $progress['amount-percent'] = number_format($model->sum / ((int)$objectAmount / 100), 2, ',', ' ');
} else {
    $progress['amount-percent'] = 100;
}

if (($progress['amount-percent'] >= 0) && ($progress['amount-percent'] <= 29)) {
    $progress['lvl-1'] = (float)$progress['amount-percent'];
    $progress['lvl-2'] = 0;
    $progress['lvl-3'] = 0;
} elseif (($progress['amount-percent'] >= 30) && ($progress['amount-percent'] <= 69)) {
    $progress['lvl-1'] = 30;
    $progress['lvl-2'] = (float)$progress['amount-percent'] - 30;
    $progress['lvl-3'] = 0;
} elseif (($progress['amount-percent'] >= 70) && ($progress['amount-percent'] <= 100)) {
    $progress['lvl-1'] = 30;
    $progress['lvl-2'] = 40;
    $progress['lvl-3'] = (float)$progress['amount-percent'] - 70;
}


?>
<div class="row catalog-user-profil">

    <?php if ($model->active) { ?>
        <div class="col-lg-12 text-center">
            <span class="btn-success">Владелец объекта</span>
        </div>
    <?php } ?>

    <div class="catalog-user-avatar col-lg-6">
        <img
            src="<?= isset($model['userAvatar']->avatar) ? $model['userAvatar']->avatar : '/img/other/default-avatar.png' ?>">
    </div>

    <div class="catalog-user-info col-lg-6">
        <div class="object-user-list-fio">
            <?php if ($model['user']->id === Yii::$app->user->id || Yii::$app->user->can('can_view_investor_info')): ?>
                <p>ФИО:
                    <a href="<?= Url::toRoute('/users/view?id=') . $model->user_id ?>" target="_blank">
                        <?= $model['user']->last_name . ' ' . $model['user']->first_name . ' ' . $model['user']->middle_name ?>
                    </a>
                </p>
            <?php else: ?>
                <p>ИД:
                    <?= $model['user']->id ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="progress">
            <div class="progress-bar progress-bar-danger span-progress-color" style="width: <?= $progress['lvl-1'] ?>%">
                <?php if (($progress['amount-percent'] >= 0) && ($progress['amount-percent'] <= 29)) {
                    echo '<span>' . $progress['amount-percent'] . '%' . '</span>';
                } ?>
            </div>
            <div class="progress-bar progress-bar-warning span-progress-color"
                 style="width: <?= $progress['lvl-2'] ?>%">
                <?php if (($progress['amount-percent'] >= 30) && ($progress['amount-percent'] <= 69)) {
                    echo '<span>' . $progress['amount-percent'] . '%' . '</span>';
                } ?>
            </div>
            <div class="progress-bar progress-bar-success span-progress-color"
                 style="width: <?= $progress['lvl-3'] ?>%">
                <?php if (($progress['amount-percent'] >= 70) && ($progress['amount-percent'] <= 100)) {
                    echo '<span>' . $progress['amount-percent'] . '%' . '</span>';
                } ?>
            </div>
        </div>

        <div>
            <p>Cумма: <?= $model->sum ?></p>
            <p>Ставка: <?= $model->rate ?></p>
            <p>Срок: <?= $model->term ?></p>
            <p>График платежей: <?= ($model->schedule_payments === 1) ? 'шаровый' : 'аннуитетный'; ?></p>
            <?php if ($model['user']->id === Yii::$app->user->id || Yii::$app->user->can('can_view_investor_info')): ?>
                <p>НКС: <?= $model->nks ?></p>
                <?php if ($model->comment) { ?>
                    <p>Пожелание: <?= $model->comment ?></p>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($finishObject) { ?>
        <div class="catalog-user-btm text-center col-lg-12">
            <?php if ($model->active) { ?>
                <div class="catalog-user-item-btm col-lg-6">
                    <?= Html::a('Забрать у инвестора', ['/object/object-finish-back?oId=' . $model->object_id . '&uId=' . $model['user']->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Вы уверены, что хотите забрать объект у инвестора?']) ?>
                </div>
            <?php } else { ?>
                <div class="catalog-user-item-btm col-lg-6">
                    <?= Html::a('Отдать инвестору', ['/object/object-finish?oId=' . $model->object_id . '&uId=' . $model['user']->id], ['class' => 'btn btn-success', 'data-confirm' => 'Вы уверены, что хотите отдать объект именно этому инвестору?']) ?>
                </div>
            <?php } ?>
            <div class="catalog-user-item-btm text-center col-lg-6">
                <?= Html::a('Удалить отклик', ['/object/unsubscribe?oId=' . $model->object_id . '&uId=' . $model['user']->id], ['class' => 'btn btn-primary', 'data-confirm' => 'Вы уверены, что хотите удалить отклик?']) ?>
            </div>
        </div>
    <?php } ?>
</div>
