<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 24.10.2018
 * Time: 10:18
 */

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\models\object\ObjectImg;

/**
 * Class ImagesController.
 */
class ImagesController extends Controller
{
    /**
     * @var int
     */
    public $width = 300;

    /**
     * @var
     */
    public $height = 300;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ArrayHelper::merge(
            [
                'width', 'height'
            ],
            parent::options($actionID)
        );
    }

    /**
     * Crop min images.
     */
    public function actionCropMin()
    {
        $models = ObjectImg::find()->all();

        /* @var $model ObjectImg */
        foreach ($models as $model) {
            $file = $model->img;
            $pi   = pathinfo($file);
            $min  = $pi['dirname'] . '/' . $pi['filename'] . '_min' . $pi['extension'];

            if (ImageHelper::crop((int)$this->width, (int)$this->height, $pi['extension'], $file, $min)) {
                $model->img_min = $min;
                $model->save();
            }
        }
    }
}