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
use yii\widgets\Pjax;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ParamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/index_param.js', [
    'depends' => [\yii\web\JqueryAsset::className()],
    'position' => \yii\web\View::POS_END]
);

$this->title = Yii::t('app/param', 'Params');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/param', 'Create {modelClass}', [
            'modelClass' => 'Param',
            ]),
                ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import', ['param/import'], [
            'id' => 'ajax_param_import',
            'class' => 'btn btn-info',
            'tabindex' => '2',
            'role' => 'button',
            'data-toggle' => 'popover',
            'data-trigger' => 'focus',
            'data-placement' => 'right',
            'data-loading-text' => 'Importing...',
        ]) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'id' => 'param-cgridview',
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
    <?php Pjax::end(); ?>

</div>
