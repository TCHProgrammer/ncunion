<?php
use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
    'options' => [
        'class' => 'all-users-moder'
    ]
]);