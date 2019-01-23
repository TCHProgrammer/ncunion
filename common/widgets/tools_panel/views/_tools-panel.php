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
    <?php if (Yii::$app->controller->id === 'catalog' && Yii::$app->controller->action->id === 'view' && Yii::$app->user->can('can_edit_object')): ?>
        <?= Html::a('Редактировать объект', Url::to(Yii::$app->urlManagerBackend->createAbsoluteUrl('object/view'), true).'?id='.Yii::$app->request->get('id'), ['class' => 'btn btn-warning']) ?>
    <?php endif; ?>
</div>
