<?php

namespace app\assets;

use yii\web\AssetBundle;

class SidebarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/simple-sidebar.css',
        'css/sidebar_layout.css',
    ];
    public $js = [
        'js/sidebar_layout.js',
    ];
    public $depends = [
        \app\assets\AppAsset::class
    ];
}
