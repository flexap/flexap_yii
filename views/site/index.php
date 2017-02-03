<?php

use kartik\sidenav\SideNav;
use app\assets\SidebarAsset;
use app\service\DbManager;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'FlexAP');
$this->params['no_layout_footer'] = true;

SidebarAsset::register($this);
?>

<div id="wrapper">
    <div id="sidebar-wrapper">
<?php
    $tables = DbManager::getTableNames();
    
    $tableItems = [];
    foreach ($tables as $table) {
        $tableItems[] = [
            'label' => $table,
            'url' => '#',
            'options' => ['onclick' => "alert('$table');"]
        ];
    }
    
    echo SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'heading' => '<span id="menu-hide" class="menu-toggle"><i class="indicator glyphicon glyphicon-chevron-left"></i></span> ' . Yii::t('app', 'Data'),
        'indItem' => '',
        'items' => [
            [
                'label' => Yii::t('app', 'Tables'),
                'active' => true,
                'items' => $tableItems,
            ],
        ],
    ]);
?>
    </div>

    <div id="page-content-wrapper">
        <span id="menu-show" class="menu-toggle"><i class="indicator glyphicon glyphicon-chevron-right"></i></span>
        
        <div class="container-fluid">
            <div class="jumbotron">
                <h1> <?= Yii::t('app', 'Congratulations!'); ?> </h1>

                <p class="lead">
                    <?= Yii::t('app', 'Index greeting'); ?></p>

                <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com"> <?= Yii::t('app','Get started with Yii'); ?> </a></p>
            </div>

            <div class="body-content">
                <div class="row">
                    <div class="col-lg-4">
                        <h2><?= Yii::t('app', 'Heading') ?></h2>

                        <p><?= Yii::t('app', 'Random text'); ?></p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/"><?= Yii::t('app','Yii Documentation') .' '. "&raquo"; ?></a></p>
                    </div>
                    <div class="col-lg-4">
                        <h2><?= Yii::t('app', 'Heading') ?></h2>

                        <p><?= Yii::t('app', 'Random text')?></p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/"><?= Yii::t('app','Yii Forum') .' '. "&raquo"; ?></a></p>
                    </div>
                    <div class="col-lg-4">
                        <h2><?= Yii::t('app', 'Heading') ?></h2>

                        <p><?= Yii::t('app', 'Random text')?></p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/"><?= Yii::t('app','Yii Extensions') .' '. "&raquo"; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    
<?= $this->render('../layouts/footer') ?>

    </div>
</div>