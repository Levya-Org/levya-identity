<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\helpers\RoleHelper;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->PROJECT_NAME;
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
            [
                'attribute'=> 'PROJECT_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'PROJECT_NAME',
            [
                'attribute'=> 'PROJECT_DESCRIPTION',
                'format' => 'raw',
                'value' => Markdown::convert($model->PROJECT_DESCRIPTION),
            ],
            'PROJECT_WEBSITE:url',
            'PROJECT_LOGO',
            'PROJECT_CREATIONDATE:datetime',
            'PROJECT_UPDATEDATE:datetime',
            'PROJECT_ISACTIVE:boolean',
            'PROJECT_ISDELETED:boolean',
            'PROJECT_ISOPEN:boolean',
            'PROJECT_PRIORITY:boolean',
        ],
    ]) ?>

</div>
