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
/* @var $token common\models\Token */

use yii\helpers\Html;
use yii\helpers\BaseUrl;

$activeLink = Yii::$app->urlManager->createAbsoluteUrl(['registration/reset', 'mail' => $user->USER_MAIL ,'token' => $token->TOKEN_CODE]);
?>
Hello <?= Html::encode($user->USER_NICKNAME) ?>

You are receiving this notification because you have (or someone pretending to be you has) requested a new password be sent for your account.
If you did not request this notification then please ignore it, if you keep receiving it please contact the board administrator.

To set the new password you need to click the link provided below.
<?= Html::a(Html::encode($activeLink), $activeLink) ?>

--
Thanks, The Levya Org. team