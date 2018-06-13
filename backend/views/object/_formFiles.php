<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

    <?php Pjax::begin(['id' => 'new_note']); ?>
    <?php $formFile = ActiveForm:: begin([
        'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true],
    ]); ?>

    <?= $formFile->field($addFile, 'title')->textInput() ?>

    <?= $formFile->field($addFile, 'doc', ['options' => ['id' => 'object-dic-file']])->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
        $get = Yii::$app->request->get();
            foreach ($listFiles as $file) {
                echo '<p>' . Html::a('X',
                        ['/object/update?id=' . $get['id'] . '&file_id=' . $file->id],
                        ['class' => 'btn btn-form-file-del btn-danger']
                    );
                echo Html::a($file->title, $file->doc, ['class' => 'form-a-del', 'data-pjax' => '0' ,'download' => true]) . '</p>';
            }
        Pjax::end();
    ?>
<br>
