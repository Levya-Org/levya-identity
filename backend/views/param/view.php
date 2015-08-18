<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Param */

$this->title = $model->PARAM_NAME;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/param', 'Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/param', 'Update'), ['update', 'id' => $model->PARAM_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/param', 'Delete'), ['delete', 'id' => $model->PARAM_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/param', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'PARAM_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'PARAM_NAME',
            'PARAM_VALUE',
            'PARAM_TYPE',
        ],
    ]) ?>

</div>
