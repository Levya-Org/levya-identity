<?php

/* 
 * Copyright (C) 2015 MATYSIAK Herve <herve.matysiak@viacesi.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use common\helpers\RoleHelper;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/view_project.js', [
    'depends' => [\yii\web\JqueryAsset::className()],
    'position' => \yii\web\View::POS_END]
);

/* @var $this yii\web\View */
/* @var $model common\models\Project */
?>

<?php
    Pjax::begin(['id' => 'pjax-member']);
    foreach ($model->r_Positions as $positionModel) {
        echo Html::tag('h3', Html::encode($positionModel->POSITION_NAME));
        echo $this->render('view_members_position', [
            'model' => $positionModel
        ]);
    }
    Pjax::end();
?>
