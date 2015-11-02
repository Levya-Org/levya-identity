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

/* @var $this yii\web\View */
/* @var $model common\models\ServiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'SERVICE_ID') ?>
    <?php endif; ?>

    <?= $form->field($model, 'SERVICE_LDAPNAME') ?>

    <?= $form->field($model, 'SERVICE_NAME') ?>
    
    <?= $form->field($model, 'SERVICE_URL') ?>

    <?= $form->field($model, 'SERVICE_DESCRIPTION') ?>

    <?= $form->field($model, 'SERVICE_ISENABLE')->checkbox() ?>

    <?= $form->field($model, 'SERVICE_STATE')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/service', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/service', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
