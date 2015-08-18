<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->USER_NICKNAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/profile', 'Profile')];
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
            'r_Country.COUNTRY_NAME',
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
