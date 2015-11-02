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
use yii\helpers\Url;

use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
?>

<?= GridView::widget([
        'id' => 'position-cgridview',
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getr_Positions()]),
        'columns' => [
            
            [
                'attribute'=> 'POSITION_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'POSITION_NAME',
            'POSITION_ISOBLIGATORY:boolean',
            'POSITION_NEEDDONATION:boolean',
            'POSITION_NEEDSUBSCRIPTION:boolean',
            'POSITION_ISDEFAULT:boolean',
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute(['position/'.$action, 'id' => $key]);
                },
                'buttonOptions' => [
                    'target' => '_blank',
                ],
            ],
        ],
]); ?>

<?= Html::a("Add Position", Url::toRoute(['position/create', 'PROJECT_PROJECT_ID' => $model->PROJECT_ID]), [
            'class' => 'btn btn-info',
        ]) ?>