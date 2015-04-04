<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PROJECT_ID') ?>

    <?= $form->field($model, 'PROJECT_NAME') ?>

    <?= $form->field($model, 'PROJECT_DESCRIPTION') ?>

    <?= $form->field($model, 'PROJECT_WEBSITE') ?>

    <?= $form->field($model, 'PROJECT_LOGO') ?>

    <?php // echo $form->field($model, 'PROJECT_CREATIONDATE') ?>

    <?php // echo $form->field($model, 'PROJECT_UPDATEDATE') ?>

    <?php // echo $form->field($model, 'PROJECT_ISACTIVE') ?>

    <?php // echo $form->field($model, 'PROJECT_ISDELETED') ?>

    <?php // echo $form->field($model, 'PROJECT_ISOPEN') ?>

    <?php // echo $form->field($model, 'PROJECT_PRIORITY') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/project', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/project', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
