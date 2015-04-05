<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Position */

$this->title = Yii::t('app/position', 'Create Position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/position', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
