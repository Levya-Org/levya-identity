<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app/profile', 'Update Profile: ', [
    'modelClass' => 'User',
]) . ' ' . $model->USER_NICKNAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/profile', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app/user', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('update_form', [
        'model' => $model,
    ]) ?>

</div>