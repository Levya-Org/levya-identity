<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserState */

$this->title = Yii::t('app/user', 'Update {modelClass}: ', [
    'modelClass' => 'User State',
]) . ' ' . $model->USERSTATE_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'User States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->USERSTATE_ID, 'url' => ['view', 'id' => $model->USERSTATE_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/user', 'Update');
?>
<div class="userstate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
