<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование роли "' . $role->description . '"';
?>

<h1><?= Html::encode($this->title) ?></h1>

<br>
<?php ActiveForm::begin() ?>
<div class="name-role">
    <div class="role-full" style="display:<?= (!in_array($role->name,['admin', 'user', 'ban', 'unknown', 'no_pay'])) ? 'block' : 'none'; ?>">
        <label class="control-label">Имя роли:</label>
        <?= Html::textInput('role[description]', $role->description ?: Yii::$app->request->post('role')['description'], ['class' => 'form-control']) ?>
    </div>

    <?php if (is_array(isset($errors['description']))){ ?>
        <?php foreach ($errors['description'] as $error){ ?>
            <br><?= $error ?>
        <?php } ?>
    <?php } ?>

    <?php if ($isNewModel){ ?>
        <div class="input-group">
            <?= Html::textInput('role[code]', Yii::$app->request->post('role')['code']) ?>
            <label class="control-label">Код</label>
        </div>
        <?php if (is_array(isset($errors['code']))){ ?>
            <?php foreach ($errors['code'] as $error){ ?>
                <br><?= $error ?>
            <?php } ?>
        <?php } ?>

    <?php } ?>
    <span class="clear"></span>
</div>
<br>
<div class="permissions-full">
    <label class="permissions-title">Доступы:</label>
    <?php foreach ($models as $model){ ?>
        <div class="permissions-item">
            <?= Html::checkbox('permissions[' . $model['name'] . ']', $model['assigned'], ['id' => 'permissions_' . $model['name'], 'class' => 'checkbox']) ?>
            <?= Html::label($model['description'], 'permissions_' . $model['name'], ['class' => 'checkbox-label']) ?>
        </div>
    <?php } ?>
</div>

<span class="clear" style="color:red;margin:10px"></span>
<br>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
