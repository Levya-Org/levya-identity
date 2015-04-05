<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PROJECT_NAME')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'PROJECT_DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PROJECT_WEBSITE')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'PROJECT_LOGO')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'PROJECT_CREATIONDATE')->textInput() ?>

    <?= $form->field($model, 'PROJECT_UPDATEDATE')->textInput() ?>

    <?= $form->field($model, 'PROJECT_ISACTIVE')->textInput() ?>

    <?= $form->field($model, 'PROJECT_ISDELETED')->textInput() ?>

    <?= $form->field($model, 'PROJECT_ISOPEN')->textInput() ?>

    <?= $form->field($model, 'PROJECT_PRIORITY')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/project', 'Create') : Yii::t('app/project', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
