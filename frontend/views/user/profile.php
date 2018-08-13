<?php

use yii\helpers\Html;
use yii\helpers\Url;
\frontend\assets\ProfileAsset::register($this);

$this->title = 'Основная информация';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="profile">
    <div class="user-profile">
        <div class="user-profile-left user-profile-margin col-sm-3 col-xs-12">
            <div class="user-avatar">
                <img src="<?= (isset($userAvatar->avatar)) ? $userAvatar->avatar : Url::to('@web/img/other/default-avatar.png') ?>" />
            </div>
        </div>
        <div class="user-profile-right user-profile-margin col-sm-9 col-xs-12">
            <div class="user-fio">
                <span><?= $user->last_name ?> <?= $user->first_name ?> <?= $user->middle_name ?></span>
            </div>
            <div class="name-compani">
                <span><?= $user->company_name ?></span>
            </div>
            <div class="name-other">
                <p>Электронная почта: <?= $user->email ?></p>
                <p>Контактный телефон: <?= $user->phone ?></p>
            </div>
        </div>
    </div>
</div>
