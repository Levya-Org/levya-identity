<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\IPHelper;
use app\models\ActionHistoryExt;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\ActionHistory */

$this->title = Yii::t('app/profile', 'Action Histories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ACTION_HISTORY_DATE:datetime',
            [
                'attribute'=> 'ACTION_HISTORY_ACTION',
                'format'=>'raw',
                'value' => function ($data) {
                    return ActionHistoryExt::actionIdtoStr($data->ACTION_HISTORY_ACTION);
                },
            ],
            [
                'attribute'=> 'ACTION_HISTORY_IP',
                'format'=>'raw',
                'value' => function ($data) {
                    return IPHelper::BinToStr($data->ACTION_HISTORY_IP);
                },
            ],
        ],
    ]); ?>

</div>