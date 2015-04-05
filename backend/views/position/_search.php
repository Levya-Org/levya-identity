<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PositionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'POSITION_ID') ?>

    <?= $form->field($model, 'POSITION_NAME') ?>

    <?= $form->field($model, 'POSITION_DESCRIPTION') ?>

    <?= $form->field($model, 'POSITION_ISOBLIGATORY') ?>

    <?= $form->field($model, 'POSITION_ISDELETED') ?>

    <?php // echo $form->field($model, 'POSITION_NEEDDONATION') ?>

    <?php // echo $form->field($model, 'POSITION_NEEDSUBSCRIPTION') ?>

    <?php // echo $form->field($model, 'PROJECT_PROJECT_ID') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/position', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/position', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
