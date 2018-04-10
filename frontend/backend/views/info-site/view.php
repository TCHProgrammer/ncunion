<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InfoSite */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Info Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-site-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'bot_title',
            'descr:ntext',
            'letter_email:email',
            'letter_phone',
            'supp_email:email',
            'supp_phone',
            'id',
        ],
    ]) ?>

</div>
