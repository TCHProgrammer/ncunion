<?php
use yii\helpers\Html;
?>

<p> <?= $contentMas['userName'] ?>, вы должны подтвердить адрес электронной почты.</p>

<p>Пройдите по ссылке: <?= Html::a(Html::encode($contentMas['link']), $contentMas['link'], ['style' => 'color:#ebec8b']); ?></p>
