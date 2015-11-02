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
use common\models\Country;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $user common\models\ProfileForm_Update */
/* @var $form yii\widgets\ActiveForm */

$isMember = RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_MEMBER);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if($isMember): ?>

        <?= $form->field($model, 'USER_LASTNAME')->textInput(['maxlength' => 80]) ?>

        <?= $form->field($model, 'USER_FORNAME')->textInput(['maxlength' => 80]) ?>
    
    <?php endif; ?>
    
    <?= $form->field($model, 'USER_NICKNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_MAIL')->textInput(['maxlength' => 254]) ?> 
    
    <?php if($isMember): ?>

        <?= $form->field($model, 'USER_MAIL_PROJECT')->textInput(['maxlength' => 80]) ?>
    
    <?php endif; ?>
    
    <?= $form->field($model, 'COUNTRY_COUNTRY_ID')->dropDownList(Country::getCountriesList(),[
        'prompt' => '- Choose your Country -'
        ]);
    ?>

    <?= $form->field($model, 'TMP_PASSWORD')->widget(PasswordInput::className(), [
        'pluginOptions' => [
            'showMeter' => true,
            'toggleMask' => true
        ]
    ]); ?>

    <?= $form->field($model, 'TMP_PASSWORD_VERIFY')->passwordInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'USER_PASSWORD_VERIFY')->passwordInput(['maxlength' => 255]) ?>
    
    <?php if($isMember): ?>

        <?= $form->field($model, 'USER_ADDRESS')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'USER_PHONE')->textInput(['maxlength' => 20]) ?>
    
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/user', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
