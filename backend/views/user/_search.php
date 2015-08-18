<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'USER_LASTNAME') ?>

    <?= $form->field($model, 'USER_FORNAME') ?>

    <?= $form->field($model, 'USER_MAIL') ?>

    <?= $form->field($model, 'USER_NICKNAME') ?>

    <?php // echo $form->field($model, 'USER_PASSWORD') ?>

    <?php // echo $form->field($model, 'USER_ADDRESS') ?>

    <?php // echo $form->field($model, 'USER_PHONE') ?>

    <?php // echo $form->field($model, 'USER_SECRETKEY') ?>

    <?php // echo $form->field($model, 'USER_CREATIONDATE') ?>

    <?php // echo $form->field($model, 'USER_REGISTRATIONDATE') ?>

    <?php // echo $form->field($model, 'USER_REGISTRATIONIP') ?>

    <?php // echo $form->field($model, 'USER_UPDATEDATE') ?>

    <?php // echo $form->field($model, 'USER_AUTHKEY') ?>

    <?php // echo $form->field($model, 'USERSTATE_USERSTATE_ID') ?>

    <?php // echo $form->field($model, 'USER_LDAPUID') ?>

    <?php // echo $form->field($model, 'r_Country') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/user', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/user', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
