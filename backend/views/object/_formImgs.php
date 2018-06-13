<?php
use yii\web\JsExpression;
use kartik\file\FileInput;
use yii\helpers\Url;

?>

<label class="control-label">Фотогалерея</label>
<?= FileInput::widget([
    /*'model' => $model,
    'attribute' => 'imgFile[]',
    'options' => ['multiple' => true],*/
    //'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => Url::to(['/site/file-upload'])]
    'name' => 'imgFile[]',
    'options'=>[
        'multiple'=>true
    ],
    'pluginOptions' => [
        'deleteUrl' => Url::toRoute(['/object/delete-img']),
        'initialPreview' => $model->imgLists,
        'initialPreviewAsData' => true,
        'overwriteInitial' => false,
        'initialPreviewConfig' => $model->imgLinkData,
        'uploadUrl' => Url::to(['/object/save-img']),
        'uploadExtraData' => [
            'class' => $model->formName(),
            'object_id' => $model->id,
        ],
        'maxFileCount' => 10
    ],
    //'options' => ['accept' => 'image/*'],
    'pluginEvents' => [
        'filesorted' => new JsExpression('function(event, params){
                    $.post("' . Url::toRoute(['/object/sort-img?id=' .
                $model->id]).'",{sort:params});
                }')
    ]
]);
?>