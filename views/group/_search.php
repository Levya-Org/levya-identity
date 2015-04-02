<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model app\models\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'GROUP_ID') ?>
    <?php endif; ?>

    <?= $form->field($model, 'GROUP_NAME') ?>
    
    <?= $form->field($model, 'GROUP_LDAPNAME') ?>

    <?= $form->field($model, 'GROUP_ISENABLE')->checkbox() ?>

    <?= $form->field($model, 'GROUP_ISDEFAULT')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/group', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/group', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
