<?php

use \yii\widgets\Pjax;
use yii\helpers\Html;

/**
 * @var \common\models\object\Object $model
 * @var \common\models\ObjectConfidence[] $objectConfidences
 * @var array $confidences
 */

?>
<?php foreach ($objectConfidences as $confidence): ?>
    <?php $errors = $confidence->getErrors();
        $file = isset($confidenceFilesList[$confidence->confidence_id]) ? $confidenceFilesList[$confidence->confidence_id] : null;
    ?>
    <div class="form-group row">
        <label class="control-label"><?= $confidences[$confidence->confidence_id] ?></label>
        <?= Html::checkbox('ObjectConfidence_' . $confidence->object_id . '_' . $confidence->confidence_id . '_check', $confidence->check) ?>
        <?= Html::input('number', 'ObjectConfidence_' . $confidence->object_id . '_' . $confidence->confidence_id . '_rate', $confidence->rate) ?>
        <?php if (key_exists('rate', $errors)): ?>
            <?php foreach ($errors['rate'] as $error): ?>
                <div class="help-block">
                    <?= $error ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </label>
        <?= $this->render('_formFile', [
            'model' => $model,
            'file' => $file,
            'addFile' => $confidenceAddFiles[$confidence->confidence_id],
            'confidenceId' => $confidence->confidence_id,
            'confidence' => $confidence,
        ]) ?>
    </div>
<?php endforeach;
