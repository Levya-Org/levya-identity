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
use yii\widgets\DetailView;

use common\helpers\RoleHelper;

?>

<?= 
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'PROJECT_ID',
                'visible' => RoleHelper::userHasRole(\Yii::$app->user->id, RoleHelper::ROLE_DEVELOPER)
            ],
            'PROJECT_LOGO',
            'PROJECT_NAME',
            [
                'attribute'=> 'PROJECT_WEBSITE',
                'format' => 'raw',
                'value' => Html::a($model->PROJECT_WEBSITE, $model->PROJECT_WEBSITE, array('target'=>'_blank')),
            ],
            'PROJECT_CREATIONDATE:datetime',
            'PROJECT_UPDATEDATE:datetime',
            'PROJECT_ISACTIVE:boolean',
            'PROJECT_ISDELETED:boolean',
            'PROJECT_ISOPEN:boolean',
            'PROJECT_PRIORITY:boolean',
        ],
    ])
?>