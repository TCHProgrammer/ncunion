<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ToolsPanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/tools-panel.css'
    ];
    public $js = [
    ];
    public $depends = [
    ];
}