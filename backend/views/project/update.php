<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = Yii::t('app/project', 'Update {modelClass}: ', [
    'modelClass' => 'Project',
]) . ' ' . $model->PROJECT_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/project', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PROJECT_ID, 'url' => ['view', 'id' => $model->PROJECT_ID]];
$this->params['breadcrumbs'][] = Yii::t('app/project', 'Update');
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
