<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Study */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Studies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
