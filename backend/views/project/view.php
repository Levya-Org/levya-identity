<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

use yii\helpers\Html;
use yii\helpers\Url;

use common\helpers\RoleHelper;

use kartik\markdown\Markdown;
use kartik\tabs\TabsX;

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
    
    <?=
    TabsX::widget([
        'position' => TabsX::POS_ABOVE,
        'align' => TabsX::ALIGN_LEFT,
        'items' => [
            [
                'label' => 'Informations',
                'content' => $this->render('view_informations', ['model' => $model]),
                'active' => true
            ],
            [
                'label' => 'Description',
                'content' => Markdown::convert($model->PROJECT_DESCRIPTION),
            ],
            [
                'label' => 'Positions',
                'content' => $this->render('view_positions', ['model' => $model]),
            ],
            [
                'label' => 'Members',
                'content' => $this->render('view_members', ['model' => $model]),
            ],
            [
                'label' => 'Member Requests',
                'content' => $this->render('view_requests', ['model' => $model]),
            ],
        ],
    ]);
    ?>

</div>
