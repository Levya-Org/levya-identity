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

namespace common\helpers;

use Yii;
use yii\log\Logger;

/**
 * Description of MailHelper
 *
 * @author Hervé
 */
class MailHelper {
    
    public static function registrationMail($user, $token){
        \Yii::getLogger()->log('registrationMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-text',
        ], [
            'user' => $user,
            'token' => $token
            ])
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Welcome to Levya Org.')
        ->send();
    }
    
    public static function registrationResendMail($user, $token){
        \Yii::getLogger()->log('registrationResendMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-resend-text',
        ], [
            'user' => $user,
            'token' => $token
            ])
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Welcome to Levya Org.')
        ->send();
    }
    
    public static function registrationResetMail($user, $token){
        \Yii::getLogger()->log('registrationResetMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-reset-text',
        ], [
            'user' => $user,
            'token' => $token
            ])
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Password reset')
        ->send();
    }
}
