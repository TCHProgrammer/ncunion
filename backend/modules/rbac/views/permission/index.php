<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Расшифровка доступов';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Добавить новый доступ', ['create-permission'], ['class' => 'btn btn-success btn-indent-margin']) ?>
</p>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Имя роли</th>
            <th>Код</th>
        </tr>
        <?php foreach ($roles as $role){ ?>

        <tr>
            <td>
                <?= $role->description ?>
            </td>
            <td> <?= $role->name ?></td>
        </tr>

        <?php } ?>
    </table>
</div>