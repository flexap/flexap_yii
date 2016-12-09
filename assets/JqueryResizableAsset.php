<?php

namespace app\assets;

use yii\web\AssetBundle;

class JqueryResizableAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-resizable/dist';
    public $js = [
        'jquery-resizable.min.js',
    ];
    public $depends = [
        \yii\web\JqueryAsset::class
    ];
}
