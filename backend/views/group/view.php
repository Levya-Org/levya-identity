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
use yii\widgets\DetailView;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = $model->GROUP_NAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/group', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/group', 'Update'), ['update', 'id' => $model->GROUP_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/group', 'Delete'), ['delete', 'id' => $model->GROUP_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/group', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'GROUP_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'GROUP_NAME',
            'GROUP_LDAPNAME',
            'GROUP_ISENABLE:boolean',
            'GROUP_ISDEFAULT:boolean',
        ],
    ]) ?>
    
    <?= $this->render('view_gas', ['model' => $model]) ?>

</div>
