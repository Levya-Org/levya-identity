<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app/user', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . ' ' . $model->USER_NICKNAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->USER_NICKNAME, 'url' => ['view', 'id' => $model->USER_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/user', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
