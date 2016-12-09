<?php

namespace app\assets;

use yii\web\AssetBundle;

class SqlAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sql_ui.css',
    ];
    public $js = [
        'js/sql_ui.js',
    ];
    public $depends = [
        \app\assets\AppAsset::class,
        \app\assets\JqueryResizableAsset::class,
        \lav45\aceEditor\AceEditorAsset::class
    ];
}
