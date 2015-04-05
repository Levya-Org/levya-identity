<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserState */

$this->title = Yii::t('app/user', 'Create {modelClass}', [
    'modelClass' => 'User State',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'User States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-state-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
