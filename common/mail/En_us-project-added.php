<?php

/* 
 * Copyright (C) 2015 Hervé
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

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $project common\models\Project */

use yii\helpers\Html;
use yii\helpers\BaseUrl;

?>
Hi <?= $user->USER_NICKNAME ?>,

You just have created a new Project on Levya ! 

----------------------------
Project name : <?= $project->PROJECT_NAME ?>
Project URL: <?= $project->PROJECT_WEBSITE ?>
----------------------------

We advice you, to read the Wiki[LINK] to see how to use the platform and get 
support.

Thank you for using Levya Org. platform.
--
The Levya Org. team