<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/user', 'Create {modelClass}', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=> 'USER_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'USER_LASTNAME',
            'USER_FORNAME',
            'USER_MAIL',
            'USER_NICKNAME',
            // 'USER_PASSWORD',
            // 'USER_ADDRESS:ntext',
            // 'USER_PHONE',
            // 'USER_SECRETKEY',
            // 'USER_CREATIONDATE',
            // 'USER_REGISTRATIONDATE',
            // 'USER_REGISTRATIONIP',
            // 'USER_UPDATEDATE',
            // 'USER_AUTHKEY',
            // 'USERSTATE_USERSTATE_ID',
            // 'USER_LDAPUID',
            // 'COUNTRIE_COUNTRY_ID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
