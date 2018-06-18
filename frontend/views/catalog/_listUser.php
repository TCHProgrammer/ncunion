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
        <div class="object-user-list-sum">
            <p><?= $model->sum ?> сумма</p>
        </div>
        <div class="object-user-list-rate">
            <p><?= $model->rate ?> ставка</p>
        </div class="object-user-list-consumption">
        <div>
           <p><?= $model->consumption ?> расход по сделке</p>
        </div>
        <div>
            <?php if($model->comment){ ?>
                <p>Пожелание: <?= $model->comment ?></p>
            <?php } ?>
        </div>
    </div>
</div>
