<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UserStateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userstate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'USERSTATE_ID') ?>
    <?php endif; ?>
    
    <?= $form->field($model, 'USERSTATE_NAME') ?>

    <?= $form->field($model, 'USERSTATE_DESCRIPTION') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/user', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/user', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
