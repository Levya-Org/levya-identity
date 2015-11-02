<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'SERVICE_ID') ?>
    <?php endif; ?>

    <?= $form->field($model, 'SERVICE_LDAPNAME') ?>

    <?= $form->field($model, 'SERVICE_NAME') ?>
    
    <?= $form->field($model, 'SERVICE_URL') ?>

    <?= $form->field($model, 'SERVICE_DESCRIPTION') ?>

    <?= $form->field($model, 'SERVICE_ISENABLE')->checkbox() ?>

    <?= $form->field($model, 'SERVICE_STATE')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/service', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/service', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
