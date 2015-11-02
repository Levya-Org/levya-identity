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
    
    <?= $form->field($model, 'POSITION_ISREQVISIBLE')->checkbox() ?>
    
    <?= $form->field($model, 'POSITION_ISDEFAULT')->checkbox() ?>

    <?= $form->field($model, 'POSITION_NEEDSUBSCRIPTION')->checkbox() ?>
    
    <?= $form->field($model, 'PROJECT_PROJECT_ID')->dropDownList(common\models\Project::getProjectsList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/position', 'Create') : Yii::t('app/position', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
