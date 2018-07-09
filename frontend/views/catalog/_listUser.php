<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="row catalog-user-profil">

    <div class="catalog-user-avatar col-lg-3">
        <img src="<?= isset($model['userAvatar']->avatar) ? $model['userAvatar']->avatar : '/img/other/default-avatar.png' ?>">
    </div>

    <div class="catalog-user-info col-lg-9">
        <div class="object-user-list-fio">
            <p>ФИО:
                <a href="<?= Url::toRoute('/admin/users/view?id=' ) . $model->user_id ?>" target="_blank">
                    <?= $model['user']->last_name . ' ' . $model['user']->first_name . ' ' . $model['user']->middle_name ?>
                </a>
            </p>
        </div>
        <div>
            <p>Cумма: <?= $model->sum ?></p>
            <p>Ставка: <?= $model->rate ?></p>
            <p>Срок: <?= $model->term ?></p>
            <p>График платежей: <?= ($model->schedule_payments === 1)?'шаровый':'аннуитетный'; ?></p>
            <p>НКС: <?= $model->nks ?></p>
            <?php if($model->comment){ ?>
                <p>Пожелание: <?= $model->comment ?></p>
            <?php } ?>
        </div>
    </div>
</div>
