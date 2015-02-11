<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SERVICE_ID') ?>

    <?= $form->field($model, 'SERVICE_LDAPNAME') ?>

    <?= $form->field($model, 'SERVICE_NAME') ?>

    <?= $form->field($model, 'SERVICE_DESCRIPTION') ?>

    <?= $form->field($model, 'SERVICE_ISENABLE') ?>

    <?php // echo $form->field($model, 'SERVICE_STATE') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/service', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/service', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
