<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Роли пользователей';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Добавить роль', ['create'], ['class' => 'btn btn-success btn-indents-right']) ?>
    <?= Html::a('Добавить новый доступ', ['create-permission'], ['class' => 'btn btn-success btn-indents-right']) ?>
</p>

<table class="table table-striped table-bordered">
    <tr>
        <th></th>
        <th>Имя роли</th>
        <th>Код</th>
        <th></th>
    </tr>
    <? foreach ($roles as $role){ ?>

    <tr>
        <td width="16px">
            <a href="/admin/rbac/roles/update?role=<?= $role->name ?>" title="Редактировать" data-pjax="0">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
        </td>
        <td>
            <?= $role->description ?>
        </td>
        <td> <?= $role->name ?></td>
        <td width="16px">
            <? if (!in_array($role->name,['admin', 'user', 'ban', 'unknown', 'no_pay'])){ ?>
                <a href="/admin/rbac/roles/delete?role=<?= $role->name ?>&back=<?=urlencode(Yii::$app->request->getUrl())?>" data-method="post" data-confirm="Вы действительно хотите удалить пользователя?">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            <?php } ?>
        </td>
    </tr>

    <?php } ?>
</table>

 <!--foreach ($roles as $role):

    var_dump($role as $k){
        var_dump($k);
    }

    <tr>
        <td width="16px">
            <a href="/admin/rbac/roles/update?role= $role->attributes['name'] ?>" title="Редактировать" data-pjax="0">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
        </td>
        <td>
           $role->attributes['description'] ?>
        </td>
        <td> $role->attributes['name'] ?></td>
        <td width="16px">
            <a href="/admin/rbac/roles/delete?role= $role->attributes['name'] ?>&back=urlencode(Yii::$app->request->getUrl())?>" data-method="post" data-confirm="Вы действительно хотите удалить пользователя?">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </td>
    </tr>

 endforeach ?>
</table>-->