<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Param */

$this->title = Yii::t('app/param', 'Create {modelClass}', [
    'modelClass' => 'Param',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/param', 'Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
