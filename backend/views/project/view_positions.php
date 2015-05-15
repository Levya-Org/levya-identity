<?php

/* 
 * Copyright (C) 2015 MATYSIAK Herve <herve.matysiak@viacesi.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getPOSITIONs()]),
        'columns' => [
            
            [
                'attribute'=> 'POSITION_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'POSITION_NAME',
            'POSITION_ISOBLIGATORY:boolean',
            'POSITION_NEEDDONATION:boolean',
            'POSITION_NEEDSUBSCRIPTION:boolean',
            
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