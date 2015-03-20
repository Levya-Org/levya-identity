<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

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
            'GROUP_ISENABLE:boolean',
            'GROUP_ISDEFAULT:boolean',
        ],
    ]) ?>

</div>
