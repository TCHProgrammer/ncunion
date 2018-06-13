<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\rbac\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */

$this->title = 'Клиент: ' . $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name;
$this->params['breadcrumbs'][] = ['label' => 'User Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <h3>Общая информация</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'id',
            'subscribe_dt',
            'last_name',
            'first_name',
            'middle_name',
            'company_name',
            'phone',
            'email:email',
            [
                'attribute' => 'check_email',
                'value' => function($model){
                    return $model->check_email ? 'Подтверждён' : 'Не подтвержён';
                }
            ],
            [
                'attribute' => 'check_phone',
                'value' => function($model){
                    return $model->check_phone ? 'Подтверждён' : 'Не подтвержён';
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->updated_at);
                }
            ],
            [
                'attribute' => 'role',
                'value' => function($model){
                    return (AuthItem::find()->select('description')->where(['name' => $model->roles->item_name])->one())->description;
                }
            ],
        ],
    ]) ?>

</div>
