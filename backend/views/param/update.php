<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Param */

$this->title = Yii::t('app/param', 'Update {modelClass}: ', [
    'modelClass' => 'Param',
]) . ' ' . $model->PARAM_NAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/param', 'Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PARAM_NAME, 'url' => ['view', 'id' => $model->PARAM_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/param', 'Update');
?>
<div class="param-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
