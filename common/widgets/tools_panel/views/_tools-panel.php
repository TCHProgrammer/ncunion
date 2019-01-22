<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\AssetBundle $asset
 */
if (isset($asset)) {
    $asset::register($this);
}
?>
<div class="tools-panel">
    <?php if (Yii::$app->user->can('can_create_object')): ?>
        <?= Html::a('Создать объект', Url::to(Yii::$app->urlManagerBackend->createAbsoluteUrl('object/create'), true), ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
</div>