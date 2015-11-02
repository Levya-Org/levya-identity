<?php

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
            ],
            'encodeLabels' => false
        ]) 
    ?>
</div>
