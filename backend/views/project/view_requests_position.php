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

$positionName = $model->POSITION_NAME;

/* @var $this yii\web\View */
/* @var $model common\models\Position */
?>

<?= Html::beginForm(['project/ajax-update'],'post',[
        'id' => 'member-request-'.$positionName.'-form',
    ]); ?>


<?= GridView::widget([
        'id' => 'member-request-'.$positionName.'-cgridview',
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'key' => 'USER_ID',
            'allModels' => $model->r_UserRequests,
        ]),
        'columns' => [
            ['class' => 'yii\grid\CheckBoxColumn'],
            
            [
                'attribute'=> 'USER_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'USER_NICKNAME',
            'USER_MAIL', 
            'cOUNTRY',
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute(['user/'.$action, 'id' => $key]);
                },
            ],
        ],
]); ?>

<?= Html::input('submit', 'doRefuseRequest', 'Dismiss', [
        'class' => 'ajax_submit-request',
        'type' => 'submit',
    ]) ?>

<?= Html::input('submit', 'doAcceptRequest', 'Nominate', [
        'class' => 'ajax_submit-request',
        'type' => 'submit'
    ]) ?>

<?php //TODO//Html::dropDownList('selected_position_id', 'selection', common\models\Position::getPositionsListByProject($model->PROJECT_PROJECT_ID)) ?>

<?= Html::hiddenInput('project_id', $model->PROJECT_PROJECT_ID) ?>
<?= Html::hiddenInput('working_position_id', $model->POSITION_ID) ?>
<?= Html::hiddenInput('selected_position_id', $model->POSITION_ID) ?>

<?= Html::endForm(); ?>
