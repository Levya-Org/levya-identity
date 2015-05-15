<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Position */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POSITION_NAME')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'POSITION_DESCRIPTION')->widget(MarkdownEditor::className()) ?>
    
    <?= $form->field($model, 'POSITION_LEVEL')->input('number', [
        'min' => 0,
        'max' => 32767
    ]) ?>

    <?= $form->field($model, 'POSITION_ISOBLIGATORY')->checkbox() ?>

    <?= $form->field($model, 'POSITION_ISDELETED')->checkbox() ?>

    <?= $form->field($model, 'POSITION_NEEDDONATION')->checkbox() ?>

    <?= $form->field($model, 'POSITION_NEEDSUBSCRIPTION')->checkbox() ?>
    
    <?= $form->field($model, 'PROJECT_PROJECT_ID')->dropDownList(common\models\Project::getProjectsList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/position', 'Create') : Yii::t('app/position', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
