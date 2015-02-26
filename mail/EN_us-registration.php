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

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $token app\models\Token */ 
$activeLink = Yii::$app->urlManager->createAbsoluteUrl(['registration/confirm', 'mail' => $user->USER_MAIL ,'token' => $token->TOKEN_CODE]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->USER_FORNAME) ?>,</p>
    
    <p> Welcome to Levya Community ! <p>

    <p> You registered with your mail : <?= Html::encode($user->USER_MAIL) ?></p>
    
    <p> Please active your account by clicking this link : <?= Html::a(Html::encode($activeLink), $activeLink) ?></p>
</div>