<?php

/* @var $this \yii\web\View */

use Yii;
?>

<footer class="footer">
    <div class="container">
        <ul class="footer-links">
            <li><a href="/site/index"><?= Yii::t('app', 'Home') ?></a></li>
            <li><a href="/site/about"><?= Yii::t('app', 'About') ?></a></li>
            <li><a href="/site/contact"><?= Yii::t('app', 'Contact') ?></a></li>
        </ul>
        
        <p class="pull-left">&copy; <?= Yii::t('app', 'FlexAP') . ' ' . date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
