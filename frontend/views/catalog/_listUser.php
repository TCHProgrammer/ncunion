<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="row catalog-user-profil">

    <div class="catalog-user-avatar col-lg-6">
        <img src="<?= $model['userAvatar']->avatar?$model['userAvatar']->avatar:'/img/other/default-avatar.png' ?>">
    </div>

    <div class="catalog-user-info col-lg-6">
        <div class="object-user-list-fio">
            <p>ФИО:
                <a href="<?= Url::toRoute('/admin/users/view?id=' ).$model->user_id ?>" target="_blank">
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

    <?php if ($finishObject){ ?>
        <div class="catalog-user-btm text-center col-lg-12">
            <div class="catalog-user-item-btm col-lg-6">
                <?= Html::a('Отдать инвестору', ['/catalog/object-finish-adm?oId='.$model->object_id.'&uId='.$model['user']->id], ['class' => 'btn btn-success', 'data-confirm' => 'Вы уверены, что хотите отдать объект именно этому инвестору?']) ?>
            </div>
            <div class="catalog-user-item-btm text-center col-lg-6">
                <?= Html::a('Отписаться', ['/catalog/unsubscribe-adm?oId='.$model->object_id.'&uId='.$model['user']->id], ['class' => 'btn btn-primary', 'data-confirm' => 'Вы уверены, что хотите отписаться?']) ?>
            </div>
        </div>
    <?php } ?>
</div>
