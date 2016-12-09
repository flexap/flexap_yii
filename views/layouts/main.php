<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'FlexAP'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => Yii::t('app', 'SQL'),
                'url' => ['/sql/shell'],
                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('app', 'Administration'),
                'items' => [
                    ['label' => Yii::t('app', ''), 'url' => ['/']],
                ],
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->getIsAdmin()
            ],
            [
                'label' => Yii::t('app', 'Access control'),
                'items' => [
                    ['label' => Yii::t('user', 'Users'), 'url' => ['/user/admin/index']],
                    ['label' => Yii::t('user', 'Roles'), 'url' => ['/rbac/role']],
                    ['label' => Yii::t('user', 'Permissions'), 'url' => ['/rbac/permission/index']],
                    ['label' => Yii::t('app', 'Rules'), 'url' => ['/rbac/rule/index']],
                ],
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->getIsAdmin()
            ],
            [
                'label' => Html::tag('strong', Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username),
                'encode' => false,
                'items' => [
                    ['label' => Yii::t('app', 'Profile'), 'url' => ['/user/settings/profile']],
                    [
                        'label' => Yii::t('app', 'Logout'), 
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ],
                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('app', 'Login'),
                'url' => ['/user/login'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('app', 'Sign Up'),
                'url' => ['/user/register'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => strtoupper(Yii::$app->language),
                'items' => [
                    ['label' => 'RU', 'url' => Url::current(['language' => 'ru'])],
                    ['label' => 'EN', 'url' => Url::current(['language' => 'en'])],
                ],
            ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
