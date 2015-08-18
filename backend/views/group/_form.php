<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GROUP_NAME')->textInput(['maxlength' => 225]) ?>
    
    <?= $form->field($model, 'GROUP_LDAPNAME')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'GROUP_ISENABLE')->checkbox() ?>

    <?= $form->field($model, 'GROUP_ISDEFAULT')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/group', 'Create') : Yii::t('app/group', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
