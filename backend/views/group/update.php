<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = Yii::t('app/group', 'Update {modelClass}: ', [
    'modelClass' => 'Group',
]) . ' ' . $model->GROUP_NAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/group', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GROUP_NAME, 'url' => ['view', 'id' => $model->GROUP_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/group', 'Update');
?>
<div class="group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
