<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\helpers\RoleHelper;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model common\models\Position */

$this->title = $model->POSITION_NAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/position', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/position', 'Update'), ['update', 'id' => $model->POSITION_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/position', 'Delete'), ['delete', 'id' => $model->POSITION_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/position', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'POSITION_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'POSITION_NAME',
            [
                'attribute'=> 'POSITION_DESCRIPTION',
                'format' => 'raw',
                'value' => Markdown::convert($model->POSITION_DESCRIPTION),
            ],
            'POSITION_LEVEL',
            'POSITION_ISOBLIGATORY:boolean',
            'POSITION_ISDELETED:boolean',
            'POSITION_NEEDDONATION:boolean',
            'POSITION_NEEDSUBSCRIPTION:boolean',
            'POSITION_ISDEFAULT:boolean',
            [
                'attribute'=> 'PROJECT_PROJECT_ID',
                'format' => 'raw',
                'value' => $model->r_Project->PROJECT_NAME,
            ],
        ],
    ]) ?>
    
    <?= $this->render('view_pas', ['model' => $model]) ?>

</div>
