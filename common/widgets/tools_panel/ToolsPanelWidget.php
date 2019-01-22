<?php

namespace common\widgets\tools_panel;

use yii\base\Widget;
use yii\web\AssetBundle;

class ToolsPanelWidget extends Widget
{
    public $asset;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $params = [];
        if (!empty($this->asset) && $this->asset instanceof AssetBundle) {
            $params['asset'] = $this->asset;
        }
        return $this->render('_tools-panel', $params);
    }
}