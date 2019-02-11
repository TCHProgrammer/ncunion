<?php

use yii\helpers\Html;
use yii\helpers\Url;
\frontend\assets\ProfileAsset::register($this);

$this->title = 'Основная информация';
?>

<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card overflowhidden m-t-20">
                    <div class="profile-header">
                        <div class="profile_info row">
                            <div class="col-lg-2 col-md-4 col-12">
                                <div class="profile-image float-md-right"> <img src="<?= (isset($userAvatar->avatar)) ? $userAvatar->avatar : Url::to('@web/img/other/default-avatar.png') ?>" alt=""> </div>
                            </div>
                            <div class="col-lg-6 col-md-8 col-12">
                                <h4 class="m-t-5 m-b-0"><strong><?= $user->first_name ?></strong> <?= $user->middle_name ?> <?= $user->last_name ?> </h4>
                                <span class="job_post"><?= $user->company_name ?></span>
                                <p>Электронная почта: <?= $user->email ?></p>
                                <p>Контактный телефон: <?= $user->phone ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <p class="m-b-0">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?> </p>
                        <p class="m-b-0">Разработанно и спроектированно компанией "РВБ-маркетинг"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--
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
-->
