<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UserState */

$this->title = $model->USERSTATE_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'User States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userstate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/user', 'Update'), ['update', 'id' => $model->USERSTATE_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/user', 'Delete'), ['delete', 'id' => $model->USERSTATE_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/user', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'USERSTATE_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'USERSTATE_NAME',
            'USERSTATE_DESCRIPTION:ntext',
            'USERSTATE_DEFAULT:boolean'
        ],
    ]) ?>

</div>
