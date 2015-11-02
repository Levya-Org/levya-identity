<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\IPHelper;
use common\models\ActionHistoryExt;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data common\models\ActionHistory */

$this->title = Yii::t('app/profile', 'Action Histories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/profile', 'Profile')];
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