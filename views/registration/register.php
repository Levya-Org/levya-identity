<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var yii\models\User $user
 */

$this->title = Yii::t('app/user', 'Sign up');
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                ]); ?>

                <?= $form->field($model, 'USER_NICKNAME') ?>

                <?= $form->field($model, 'USER_MAIL') ?>

                <?= $form->field($model, 'USER_PASSWORD')->passwordInput() ?>

                <?= Html::submitButton(Yii::t('app/user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('app/user', 'Already registered? Sign in!'), ['/user/login']) ?>
        </p>
    </div>
</div>