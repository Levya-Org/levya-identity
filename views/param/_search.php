<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ParamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="param-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php if(RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'PARAM_ID') ?>
    <?php endif; ?>

    <?= $form->field($model, 'PARAM_NAME') ?>

    <?= $form->field($model, 'PARAM_VALUE') ?>

    <?= $form->field($model, 'PARAM_TYPE') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/param', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/param', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
