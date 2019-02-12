<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="profile-header catalog-user-profil">
    <div class="profile_info row">
        <div class="col-xs-12 col-sm-3">
            <div class="profile-image catalog-user-avatar float-md-right"> <img src="<?= isset($model['userAvatar']->avatar) ? $model['userAvatar']->avatar : '/img/other/default-avatar.png' ?>"> </div>
        </div>
        <div class="col-xs-12 col-sm-9">
            <?php if ($model->user_id === Yii::$app->user->id  || Yii::$app->user->can('can_view_investor_info')): ?>
                <h4>
                    ФИО:
                    <a href="<?= Url::toRoute('/admin/users/view?id=' ) . $model->user_id ?>" target="_blank">
                        <?= $model['user']->last_name . ' ' . $model['user']->first_name . ' ' . $model['user']->middle_name ?>
                    </a>
                </h4>
                <p>Cумма: <?= $model->sum ?></p>
                <p>Ставка: <?= $model->rate ?></p>
                <p>Срок: <?= $model->term ?></p>
                <p>График платежей: <?= ($model->schedule_payments === 1)?'шаровый':'аннуитетный'; ?></p>
                <p>НКС: <?= $model->nks ?></p>
                <?php if($model->comment){ ?>
                    <p>Пожелание: <?= $model->comment ?></p>
                <?php } ?>
            <?php else: ?>
                <h4 class="m-t-5 m-b-0">
                    ИД: <?= $model->user_id ?>
                </h4>
                <p>Cумма: <?= $model->sum ?></p>
                <p>Ставка: <?= $model->rate ?>  </p>
                <p>Срок: <?= $model->term ?></p>
                <p>График платежей: <?= ($model->schedule_payments === 1)?'шаровый':'аннуитетный'; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
