<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->USER_NICKNAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/profile', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/user', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'USER_LASTNAME',
                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
            ],
            [
                'attribute'=> 'USER_FORNAME',
                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
            ],
            'USER_MAIL',
            'USER_NICKNAME', 
            [
                'attribute'=> 'USER_ADDRESS',
                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
            ],
            'cOUNTRY',
            [
                'attribute'=> 'USER_PHONE',
                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
            ],            
            'USER_LDAPUID',
            'USER_CREATIONDATE:datetime',
            'USER_REGISTRATIONDATE:datetime',
        ],
    ]) ?>

</div>
