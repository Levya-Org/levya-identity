<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->GROUP_ID;
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
            'GROUP_ID',
            'GROUP_NAME',
            'GROUP_ISENABLE',
            'GROUP_ISDEFAULT',
        ],
    ]) ?>

</div>
