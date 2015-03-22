<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\RoleHelper;
use app\models\UserState;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(RoleHelper::userHasRole($model->USER_ID, RoleHelper::ROLE_DEVELOPER)): ?>
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

    <?= $form->field($model, 'cOUNTRY')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/user', 'Create') : Yii::t('app/user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
