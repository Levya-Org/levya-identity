<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\helpers\RoleHelper;

use kartik\date\DatePicker;
use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PROJECT_NAME')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'PROJECT_DESCRIPTION')->widget(MarkdownEditor::className()) ?>

    <?= $form->field($model, 'PROJECT_WEBSITE')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'PROJECT_LOGO')->textInput(['maxlength' => 50]) ?>

    <?php if(RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_ADMINISTRATOR) && !$model->isNewRecord): ?>
        <?= $form->field($model, 'PROJECT_CREATIONDATE')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Project Creation Date ...'],
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true                
            ]
        ]); 
        ?>
    <?php endif; ?>

    <?= $form->field($model, 'PROJECT_ISACTIVE')->checkbox() ?>

    <?= $form->field($model, 'PROJECT_ISDELETED')->checkbox() ?>

    <?= $form->field($model, 'PROJECT_ISOPEN')->checkbox() ?>

    <?= $form->field($model, 'PROJECT_PRIORITY')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/project', 'Create') : Yii::t('app/project', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
