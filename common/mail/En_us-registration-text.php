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
/* @var $user app\models\User */
/* @var $token app\models\Token */

use yii\helpers\Html;
use yii\helpers\BaseUrl;

$activeLink = Yii::$app->urlManager->createAbsoluteUrl(['registration/confirm', 'mail' => $user->USER_MAIL ,'token' => $token->TOKEN_CODE]);
?>
Welcome to Levya Org.,

Please keep this email for your records. Your account information is as follows:

----------------------------
Username: <?= $user->USER_NICKNAME ?>
Indentity URL: <?= BaseUrl::home() ?>
----------------------------

Please visit the following link in order to activate your account:
<?= $activeLink ?>

Thank you for registering.
--
The Levya Org. team