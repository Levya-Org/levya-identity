<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\RoleHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/index_param.js', [
    'depends' => [\yii\web\JqueryAsset::className()],
    'position' => \yii\web\View::POS_END]
);

$this->title = Yii::t('app/param', 'Params');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="param-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/param', 'Create {modelClass}', [
            'modelClass' => 'Param',
            ]),
                ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import', ['param/import'], [
            'id' => 'ajax_param_import',
            'class' => 'btn btn-info',
            'tabindex' => '2',
            'role' => 'button',
            'data-toggle' => 'popover',
            'data-trigger' => 'focus',
            'data-placement' => 'right',
            'data-loading-text' => 'Importing...',
        ]) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'id' => 'param-cgridview',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=> 'PARAM_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'PARAM_NAME',
            'PARAM_VALUE',
            'PARAM_TYPE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
