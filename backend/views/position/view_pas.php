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
use common\helpers\RoleHelper;
use yii\widgets\Pjax;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/view_pas.js', [
    'depends' => [\yii\web\JqueryAsset::className()],
    'position' => \yii\web\View::POS_END]
);

/* @var $this yii\web\View */
/* @var $model common\models\Position */
?>
<div class="position-pas-view">

    <h3><?= Html::encode('Services') ?></h3>

    <?= Html::beginForm(['position/ajax-update'],'post',[
        'id' => 'service-form',
    ]); ?>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'id' => 'service-cgridview',
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getr_Services()]),
        'columns' => [
            
            ['class' => 'yii\grid\CheckboxColumn'],
            
            [
                'attribute'=> 'SERVICE_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'SERVICE_NAME',
            'SERVICE_ISENABLE:boolean',
            'SERVICE_STATE:boolean'
        ],
    ]); ?>
    <?php Pjax::end() ?>
    <?= Html::dropDownList('service', 'selection', common\models\Service::getServicesList()) ?>
    
    <?= Html::hiddenInput('position_id', $model->POSITION_ID) ?>
    
    <?= Html::input('submit', 'doAdd', 'Add Service', [
        'id' => 'ajax_submit_add',
        'type' => 'submit'
    ]) ?>
    
    <?= Html::input('submit', 'doRemove', 'Remove Service(s)', [
        'id' => 'ajax_submit_remove',
        'type' => 'submit'
    ]) ?>
    
    <?= Html::endForm(); ?>

</div>
