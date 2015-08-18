<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SERVICE_LDAPNAME')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'SERVICE_NAME')->textInput(['maxlength' => 225]) ?>

    <?= $form->field($model, 'SERVICE_DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SERVICE_ISENABLE')->textInput()->checkbox() ?>

    <?= $form->field($model, 'SERVICE_STATE')->textInput()->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/service', 'Create') : Yii::t('app/service', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
