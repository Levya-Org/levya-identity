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
use common\models\UserState;
use yii\helpers\BaseUrl;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)): ?>
        <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => 10]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'USER_LASTNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_FORNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_MAIL')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'USER_NICKNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'TMP_PASSWORD')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'USER_ADDRESS')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'USER_PHONE')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'USER_SECRETKEY')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USERSTATE_USERSTATE_ID')->dropDownList(UserState::getUserStatesList()) ?>

    <?= Html::activeLabel($model, 'COUNTRY_COUNTRY_ID') ?>
    <?= AutoComplete::widget([
        'id' => 'auto-country',
        'name' => 'auto_country',
        'clientOptions' => [
            'source' => BaseUrl::toRoute('geodata/country'),
            'minLength' => 2,
            'create' => new yii\web\JsExpression(
                    'function(event, ui) {
                        $.getJSON( "'. BaseUrl::toRoute(['geodata/country-by-id', 'id' => $model->COUNTRY_COUNTRY_ID]) .'", function( data ) {
                            $(this).val(data[0].value);
                        });
                      }'
                    ),
            'select' => new yii\web\JsExpression(
                'function(event, ui) {
                    event.preventDefault();
                    $(this).val(ui.item.value);
                    $("#' . Html::getInputId($model, 'COUNTRY_COUNTRY_ID') . '").val(ui.item.id);
                }'
            )
        ],
    ]); ?>
    
    <?= Html::activeHiddenInput($model, 'COUNTRY_COUNTRY_ID'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/user', 'Create') : Yii::t('app/user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
