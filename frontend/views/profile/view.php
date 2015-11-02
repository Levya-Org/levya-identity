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
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use common\helpers\RoleHelper;

use common\models\Service;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->USER_NICKNAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/profile', 'Profile')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/user', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <?=
        Tabs::widget([
            'items' => [
                [
                    'label'=>'<i class="glyphicon glyphicon-user"></i> Informations',
                    'content' => DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=> 'USER_LASTNAME',
                                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
                            ],
                            [
                                'attribute'=> 'USER_FORNAME',
                                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
                            ],
                            'USER_MAIL',
                            'USER_NICKNAME', 
                            [
                                'attribute'=> 'USER_ADDRESS',
                                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
                            ],
                            'r_Country.COUNTRY_NAME',
                            [
                                'attribute'=> 'USER_PHONE',
                                'visible'=> RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER),
                            ],            
                            'USER_LDAPUID',
                            'USER_CREATIONDATE:datetime',
                            'USER_REGISTRATIONDATE:datetime',
                        ],
                    ])
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-th-list"></i> Services',
                    'content' => GridView::widget([
                        'dataProvider' => new yii\data\ArrayDataProvider([
                            'allModels' => Service::getServicesByUser($model->USER_ID),
                        ]), 
                        'columns' => [
                            'SERVICE_NAME',
                            'SERVICE_URL:url',
                            'SERVICE_ISENABLE:boolean',
                            'SERVICE_STATE:boolean',                        
                        ],
                    ])
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-briefcase"></i> Projects',
                    'headerOptions' => ['class'=>'disabled']
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-credit-card"></i> Memberships',
                    'headerOptions' => ['class'=>'disabled']
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-heart-empty"></i> Donations',
                    'headerOptions' => ['class'=>'disabled']
                ],
            ],
            'encodeLabels' => false
        ]) 
    ?>
</div>
