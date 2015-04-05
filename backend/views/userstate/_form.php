<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserState */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userstate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USERSTATE_NAME')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'USERSTATE_DESCRIPTION')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/user', 'Create') : Yii::t('app/user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
