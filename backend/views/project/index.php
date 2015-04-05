<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/project', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/project', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PROJECT_ID',
            'PROJECT_NAME',
            'PROJECT_DESCRIPTION:ntext',
            'PROJECT_WEBSITE',
            'PROJECT_LOGO',
            // 'PROJECT_CREATIONDATE',
            // 'PROJECT_UPDATEDATE',
            // 'PROJECT_ISACTIVE',
            // 'PROJECT_ISDELETED',
            // 'PROJECT_ISOPEN',
            // 'PROJECT_PRIORITY',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
