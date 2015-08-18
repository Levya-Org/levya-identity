<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Service */

$this->title = Yii::t('app/service', 'Update {modelClass}: ', [
    'modelClass' => 'Service',
]) . ' ' . $model->SERVICE_NAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/service', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SERVICE_NAME, 'url' => ['view', 'id' => $model->SERVICE_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/service', 'Update');
?>
<div class="service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
