<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->USER_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/user', 'Update'), ['update', 'id' => $model->USER_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/user', 'Delete'), ['delete', 'id' => $model->USER_ID], [
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
            'USER_ID',
            'USER_LASTNAME',
            'USER_FORNAME',
            'USER_MAIL',
            'USER_NICKNAME',
            'USER_PASSWORD',
            'USER_ADDRESS:ntext',
            'USER_PHONE',
            'USER_SECRETKEY',
            'USER_CREATIONDATE',
            'USER_REGISTRATIONDATE',
            'USER_REGISTRATIONIP',
            'USER_UPDATEDATE',
            'USER_AUTHKEY',
            'USERSTATE_USERSTATE_ID',
            'USER_LDAPUID',
            'COUNTRIE_CountryId',
            'REGION_RegionID',
            'CITIE_CityId',
        ],
    ]) ?>

</div>
