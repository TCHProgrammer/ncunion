<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php Pjax::begin(); ?>

<?php
if  (isset($file)) {
    $get = Yii::$app->request->get();
    echo '<p>' . Html::a('X',
            ['/object/update?id=' . $get['id'] . '&file_id=' . $file->id. '&confidence_id=' . $confidenceId],
            ['class' => 'btn btn-form-file-del btn-danger']
        );
    echo Html::a($file->title, $file->doc, ['class' => 'form-a-del', 'data-pjax' => '0', 'download' => true]) . '</p>';

} else { ?>

    <?= Html::fileInput('ObjectConfidence_' . $confidence->object_id . '_' . $confidence->confidence_id . '_file') ?>
    <?= Html::hiddenInput('ObjectConfidence_' . $confidence->object_id . '_' . $confidence->confidence_id . '_confidence_id', $addFile->confidence_id) ?>
    <?= Html::hiddenInput('ObjectConfidence_' . $confidence->object_id . '_' . $confidence->confidence_id . '_object_id', $addFile->object_id) ?>

<?php } ?>

<?php
Pjax::end();
?>
<br>
