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
