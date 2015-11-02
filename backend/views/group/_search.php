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
/* @var $model common\models\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'GROUP_ID') ?>
    <?php endif; ?>

    <?= $form->field($model, 'GROUP_NAME') ?>
    
    <?= $form->field($model, 'GROUP_LDAPNAME') ?>

    <?= $form->field($model, 'GROUP_ISENABLE')->checkbox() ?>

    <?= $form->field($model, 'GROUP_ISDEFAULT')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/group', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/group', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
