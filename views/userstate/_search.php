<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserStateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userstate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'USERSTATE_ID') ?>

    <?= $form->field($model, 'USERSTATE_NAME') ?>

    <?= $form->field($model, 'USERSTATE_DESCRIPTION') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/user', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/user', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
