<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'FlexAP');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1> <?= Yii::t('app','Congratulations!'); ?> </h1>

        <p class="lead">
            <?= Yii::t('app', 'Index greeting'); ?></p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com"> <?= Yii::t('app','Get started with Yii'); ?> </a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2><?= Yii::t('app','Heading') ?></h2>

                <p><?= Yii::t('app', 'Random text'); ?></p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/"><?= Yii::t('app','Yii Documentation') .' '. "&raquo"; ?></a></p>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app','Heading') ?></h2>

                <p><?= Yii::t('app','Random text')?></p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/"><?= Yii::t('app','Yii Forum') .' '. "&raquo"; ?></a></p>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app','Heading') ?></h2>

                <p><?= Yii::t('app','Random text')?></p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/"><?= Yii::t('app','Yii Extensions') .' '. "&raquo"; ?></a></p>
            </div>
        </div>

    </div>
</div>
