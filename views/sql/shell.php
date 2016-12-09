<?php

use yii\helpers\Html;
use lav45\aceEditor\AceEditorWidget;
use app\assets\SqlAsset;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'SQL shell');

SqlAsset::register($this);
?>
<div class="body-content panel-container-vertical">
    <div class="panel-top">
<?php
    echo AceEditorWidget::widget([
//        'theme' => 'github',
        'name' => 'sql-editor',
        'mode'=>'sql',
        'value' => 'SHOW TABLES;',
        'showPrintMargin' => true,
        'fontSize' => 14,
        'height' => 120,
        'options' => [
            'id' => 'sql-editor',
            'style' => 'border: 1px solid #ccc; border-radius: 2px;'
        ]
    ]);
?>
    </div>
    <div class="splitter">
        <form class="form-inline">
            <span class="action-panel">
                <?= Html::button(Yii::t('app', 'Run SQL script'), ['id' => 'run-button', 'class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::button(Yii::t('app', 'Clean output'), ['id' => 'clean-button', 'class' => 'btn btn-default btn-sm']) ?>
            </span>
            <div class="form-group">
                <?= Html::tag('span', Yii::t('app', 'Parameters')) ?>
                <?= Html::textInput(null, '--table --verbose', ['id' => 'params', 'class' => 'form-control input-sm']) ?>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <?= Html::input('checkbox', null, null, ['id' => 'use-file']) ?>
                    </label>
                </div>
                <?= Html::tag('span', Yii::t('app', 'Use temp file')) ?>
            </div>
        </form>
    </div>
    <div class="panel-bottom">
        <pre class="sql-output">
        </pre>
    </div>
</div>