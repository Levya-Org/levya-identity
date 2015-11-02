<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\helpers\RoleHelper;

use kartik\date\DatePicker;
use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
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
    
    <?= $form->field($model, 'PROJECT_PRIORITY')->input('number', [
        'min' => 0,
        'max' => 32767
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/project', 'Create') : Yii::t('app/project', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
