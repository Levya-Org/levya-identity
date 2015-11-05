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

$activeLink = Yii::$app->urlManager->createAbsoluteUrl(['registration/confirm', 'mail' => $user->USER_MAIL ,'token' => $token->TOKEN_CODE]);
//TODO : Indentity profile
//TODO : Membership date 
?>
Welcome to Levya Org.,

Please keep this email for your records. Your account information is as follows:

----------------------------
Username: <?= $user->USER_NICKNAME ?>
Forname: <?= $user->USER_FORNAME ?>
Lastname: <?= $user->USER_LASTNAME ?>
Begin of membership: <?= "todo" ?>
Indentity URL: <?= BaseUrl::home(true) ?>
----------------------------

Please confirm your account primary email : 
<?= $activeLink ?>

What you must do, if you don't have before :
> Read the Statute
> Read the Intern Rule

What you can do :
> Search project to work for
> Revive project 
> Create a new project
> Update your Curiculum Vitae :)

Thank you for registering and suporting Levya.
--
The Levya Org. team