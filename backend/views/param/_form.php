<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Param */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="param-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PARAM_NAME')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'PARAM_VALUE')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'PARAM_TYPE')->textInput(['maxlength' => 20]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/param', 'Create') : Yii::t('app/param', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
