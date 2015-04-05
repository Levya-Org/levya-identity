<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Position */

$this->title = Yii::t('app/position', 'Update {modelClass}: ', [
    'modelClass' => 'Position',
]) . ' ' . $model->POSITION_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/position', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->POSITION_ID, 'url' => ['view', 'id' => $model->POSITION_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/position', 'Update');
?>
<div class="position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
