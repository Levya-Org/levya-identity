<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/param', 'Params');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/param', 'Create {modelClass}', [
    'modelClass' => 'Param',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=> 'PARAM_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'PARAM_NAME',
            'PARAM_VALUE',
            'PARAM_TYPE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
