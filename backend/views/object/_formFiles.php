<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/*$this->registerJs(
    '$("document").ready(function(){
            $("#new_note0").on("pjax:end", function() {
            $.pjax.reload({container:"#kek"});  //Reload GridView
        });
    });'
);*/

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

<div id="kek">
    <?php
        $get = Yii::$app->request->get();
        if (Yii::$app->request->isAjax ){
            echo 'хуй';
        }
            foreach ($listFiles as $file) {
                /*echo '
                    <p>
                        <button class="btn-form-file-del">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                        <a href="' . $file->doc . '" download>' . $file->title . '</a>
                    </p>
                ';*/
                echo '<p>' . Html::a('X',
                        ['/object/update?id=' . $get['id'] . '&file_id=' . $file->id],
                        ['class' => 'btn btn-form-file-del btn-danger']
                    );
                echo Html::a($file->title, $file->doc, ['class' => 'form-a-del', 'data-pjax' => '0' ,'download' => true]) . '</p>';
            }
        Pjax::end();
    ?>
</div>
<br>
