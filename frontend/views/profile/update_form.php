<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\RoleHelper;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $user app\models\ProfileForm_Update */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_MEMBER)): ?>

        <?= $form->field($model, 'USER_LASTNAME')->textInput(['maxlength' => 80]) ?>

        <?= $form->field($model, 'USER_FORNAME')->textInput(['maxlength' => 80]) ?>
    
    <?php endif; ?>
    
    <?= $form->field($model, 'USER_NICKNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_MAIL')->textInput(['maxlength' => 254]) ?> 

    <?= $form->field($model, 'TMP_PASSWORD')->widget(PasswordInput::className(), [
        'pluginOptions' => [
            'showMeter' => true,
            'toggleMask' => true
        ]
    ]); ?>

    <?= $form->field($model, 'TMP_PASSWORD_VERIFY')->passwordInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'USER_PASSWORD_VERIFY')->passwordInput(['maxlength' => 255]) ?>
    
    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_MEMBER)): ?>

        <?= $form->field($model, 'USER_ADDRESS')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'USER_PHONE')->textInput(['maxlength' => 20]) ?>
    
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/user', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
