<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'USER_LASTNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_FORNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_MAIL')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'USER_NICKNAME')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_PASSWORD')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'USER_ADDRESS')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'USER_PHONE')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'USER_SECRETKEY')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'USER_CREATIONDATE')->textInput() ?>

    <?= $form->field($model, 'USER_REGISTRATIONDATE')->textInput() ?>

    <?= $form->field($model, 'USER_REGISTRATIONIP')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'USER_UPDATEDATE')->textInput() ?>

    <?= $form->field($model, 'USER_AUTHKEY')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'USERSTATE_USERSTATE_ID')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'USER_LDAPUID')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'COUNTRIE_CountryId')->textInput() ?>

    <?= $form->field($model, 'REGION_RegionID')->textInput() ?>

    <?= $form->field($model, 'CITIE_CityId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/user', 'Create') : Yii::t('app/user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
