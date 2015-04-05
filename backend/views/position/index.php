<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/position', 'Positions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/position', 'Create Position'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=> 'POSITION_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'POSITION_NAME',
            'POSITION_ISOBLIGATORY:boolean',
            'POSITION_NEEDDONATION:boolean',
            'POSITION_NEEDSUBSCRIPTION:boolean',
            // 'PROJECT_PROJECT_ID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
