<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->PROJECT_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/project', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/project', 'Update'), ['update', 'id' => $model->PROJECT_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/project', 'Delete'), ['delete', 'id' => $model->PROJECT_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/project', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PROJECT_ID',
            'PROJECT_NAME',
            'PROJECT_DESCRIPTION:ntext',
            'PROJECT_WEBSITE',
            'PROJECT_LOGO',
            'PROJECT_CREATIONDATE',
            'PROJECT_UPDATEDATE',
            'PROJECT_ISACTIVE',
            'PROJECT_ISDELETED',
            'PROJECT_ISOPEN',
            'PROJECT_PRIORITY',
        ],
    ]) ?>

</div>
