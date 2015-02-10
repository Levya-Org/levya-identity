<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 */

?>

<?php if (Yii::$app->session->hasFlash('user.password_generated')): ?>
    <div class="alert alert-info">
        <h4>
            <?= Yii::t('app/user', 'Password has been generated automatically') ?>
        </h4>
        <p>
            <?= Yii::t('app/user', 'We have generated password for you and sent to you via email') ?>.
            <?= Yii::t('app/user', 'The email can take a few minutes to arrive') ?>.
        </p>
    </div>
<?php endif ?>

<?php if (Yii::$app->session->hasFlash('user.registration_finished')): ?>
    <?php $this->title = Yii::t('app/user', 'Account has been created'); ?>
    <div class="alert alert-success">
        <h4>
            <?= Html::encode($this->title) ?>
        </h4>
        <?= Yii::t('app/user', 'Thank you for signing up on our website') ?>.
        <?= Yii::t('app/user', 'Your account has been created and you have been automatically logged in') ?>.
    </div>
<?php endif ?>

<?php if (Yii::$app->session->hasFlash('user.confirmation_sent')): ?>
    <?php $this->title = Yii::t('app/user', 'We need to confirm your email address'); ?>
    <div class="alert alert-info">
        <h4>
            <?= Html::encode($this->title) ?>
        </h4>
        <p>
            <?= Yii::t('app/user', 'Please check your email and click the confirmation link to complete your registration') ?>.
            <?= Yii::t('app/user', 'The email can take a few minutes to arrive') ?>.
            <?= Yii::t('app/user', 'But if you are having troubles, you can request a new one by clicking the link below') ?>:
        </p>
        <p>
            <?= Html::a(Yii::t('app/user', 'Request new confirmation message'), ['/registration/resend']) ?>
        </p>
    </div>
<?php endif ?>

<?php if (Yii::$app->session->hasFlash('user.invalid_token')): ?>
    <?php $this->title = Yii::t('app/user', 'Invalid token'); ?>
    <div class="alert alert-danger">
        <h4>
            <?= Html::encode($this->title) ?>
        </h4>
        <p>
            <?= Yii::t('app/user', 'We are sorry but your confirmation token is out of date') ?>.
            <?= Yii::t('app/user', 'You can try requesting a new one by clicking the link below') ?>:
        </p>
        <p>
            <?= Html::a(Yii::t('app/user', 'Request new confirmation message'), ['/registration/resend']) ?>
        </p>
    </div>
<?php endif ?>

<?php if (Yii::$app->session->hasFlash('user.confirmation_finished')): ?>
    <?php $this->title = Yii::t('app/user', 'Account has been confirmed'); ?>
    <div class="alert alert-success">
        <h4>
            <?= Html::encode($this->title) ?>
        </h4>
        <?= Yii::t('app/user', 'Awesome! You have successfully confirmed your email address. You may sign in using your credentials now') ?>
    </div>
<?php endif ?>
