<?php
use yii\widgets\ListView;
use yii\helpers\Html;
?>
<!-- DEL!!!!!!!! -->
<h2>Список откликнувшихся инвесторов</h2>

<?= ListView::widget([
    'dataProvider' => $usersObjectlist,
    'itemView' => '_listUser',
]); ?>