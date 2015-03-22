<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserStateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/user', 'User States');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userstate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/user', 'Create {modelClass}', [
    'modelClass' => 'User State',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=> 'USERSTATE_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'USERSTATE_NAME',
            'USERSTATE_DESCRIPTION:ntext',
            'USERSTATE_DEFAULT:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
