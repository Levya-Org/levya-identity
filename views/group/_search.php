<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'GROUP_ID') ?>

    <?= $form->field($model, 'GROUP_NAME') ?>

    <?= $form->field($model, 'GROUP_ISENABLE') ?>

    <?= $form->field($model, 'GROUP_ISDEFAULT') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/group', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/group', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
