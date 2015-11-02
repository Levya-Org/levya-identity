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

/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SERVICE_LDAPNAME')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'SERVICE_NAME')->textInput(['maxlength' => 225]) ?>
    
    <?= $form->field($model, 'SERVICE_URL')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'SERVICE_DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SERVICE_ISENABLE')->textInput()->checkbox() ?>

    <?= $form->field($model, 'SERVICE_STATE')->textInput()->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/service', 'Create') : Yii::t('app/service', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
