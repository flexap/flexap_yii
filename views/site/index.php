<?php

use kartik\grid\GridView;
use kartik\sidenav\SideNav;
use app\assets\SidebarAsset;
use app\service\DbManager;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\bootstrap\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'FlexAP');
$this->params['no_layout_footer'] = true;

SidebarAsset::register($this);
?>

<div id="wrapper">
    <div id="sidebar-wrapper">
<?php
    $tableExist = false;
    $tables = DbManager::getTableNamesAndCaptions();
    
    $tableItems = [];
    foreach ($tables as $table) {
        $name = $table['name'];
        $caption = $table['caption'];
        $item = [
            'label' => empty($caption) ? $name : Yii::t('app', $caption) . "<br><small class=\"data-description\">$name</small>",
            'url' => ['/', 'tableName' => $name]
        ];
        if (!empty($tableName) && $tableName === $name) {
            $item['active'] = true;
            $tableCaption = $caption;
            $tableExist = true;
        }
        $tableItems[] = $item;
    }
    
    echo SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'heading' => '<span id="menu-hide" class="menu-toggle"><i class="indicator glyphicon glyphicon-chevron-left"></i></span> ' . Yii::t('app', 'Data'),
        'indItem' => '',
        'encodeLabels' => false,
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
            
<?php
    if (!empty($tableName) && $tableExist):
    
        $db = DbManager::getDbConnection();
        $count = (new Query())->from($tableName)->count('*', $db);

        $dataProvider = new SqlDataProvider([
            'db' => $db,
            'sql' => (new Query())->from($tableName)->createCommand($db)->getRawSql(),
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
?>
    <h1 class="data-caption"><?= Html::encode(!empty($tableCaption) ? Yii::t('app', $tableCaption) : $tableName) ?></h1>
    <?php if (!empty($tableCaption)): ?>
        <p class="data-description"><?= Yii::t('app', 'Table') . " <strong>$tableName</strong>" ?></p>
    <?php endif; ?>

    <?= GridView::widget([
//        'caption' => Yii::t('app', 'Table') . " \"$tableName\"",
        'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
//            'columns' => /$gridColumns,
        'resizableColumns' => true,
        'responsive' => true,
        'hover' => true
    ]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'New record'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif; ?>
    <!--        
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
    -->
        </div>

    </div>
</div>