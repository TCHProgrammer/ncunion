<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
    <?php
    /*var_dump($_SESSION);
    $session = Yii::$app->session;
    var_dump($session->isActive);*/
    ?>

<div class="bs-callout bs-callout-warning">
    <h2>Вы вошли в админ панель</h2>
</div>

<div>
    <img src="https://s00.yaplakal.com/pics/userpic/9/3/7/av-714739.jpg" />
</div>

canAdmin = <?= Yii::$app->user->can('canAdmin') ?>
<br>
admin = <?= Yii::$app->user->can('admin') ?>
<br>
manager = <?= Yii::$app->user->can('manager') ?>
<br>
