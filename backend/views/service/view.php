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
/* @var $model common\models\Service */

$this->title = $model->SERVICE_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/service', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/service', 'Update'), ['update', 'id' => $model->SERVICE_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/service', 'Delete'), ['delete', 'id' => $model->SERVICE_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/service', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'SERVICE_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'SERVICE_LDAPNAME',
            'SERVICE_NAME',
            'SERVICE_URL:url',
            'SERVICE_DESCRIPTION:ntext',
            'SERVICE_ISENABLE:boolean',
            'SERVICE_STATE:boolean',
        ],
    ]) ?>

</div>
