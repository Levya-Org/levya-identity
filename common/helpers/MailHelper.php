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

namespace common\helpers;

use Yii;
use yii\log\Logger;

/**
 * Description of MailHelper
 *
 * @author Hervé
 */
class MailHelper {
    
    /**
     * Mail sended at User registration
     * @param type $user
     * @param type $token
     */
    public static function registrationMail($user, $token){
        \Yii::getLogger()->log('registrationMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-register-text',
        ], [
            'user' => $user,
            'token' => $token
            ])
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Welcome to Levya Org.')
        ->send();
    }
    
    /**
     * Mail sended at Member registration
     * @param type $user
     * @param type $file
     */
    public static function registrationMemberMail($user, $token){
        \Yii::getLogger()->log('registrationMemberMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-register-member-text',
        ], [
            'user' => $user,
            'token' => $token
            ]) 
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Welcome to Levya Org. Member')
        ->send();
    }
    
    /**
     * Mail sended for new Member (1 time)
     * Send Internal Rule file
     * @param type $user
     * @param type $file
     */
    public static function internalRuleMail($user, $file){
        \Yii::getLogger()->log('registrationMemberMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-register-member-ir-text',
        ], [
            'user' => $user,
            'file' => $file
            ])
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Interal Rules')
        ->attach($file)
        ->send();
    }
    
    /**
     * Mail sended for new Member (1 time)
     * Send Statute file
     * @param type $user
     * @param type $file
     */
    public static function statuteMail($user, $file){
        \Yii::getLogger()->log('registrationMemberMail', Logger::LEVEL_TRACE);
        Yii::$app->mailer->compose([
            'text' => 'En_us-registration-register-member-ir-text',
        ], [
            'user' => $user,
            'file' => $file
            ])
        ->setFrom(['no-reply@indentity.levya.org' => 'Levya.Org Indentity'])
        ->setTo($user->USER_MAIL)
        ->setSubject('[Levya Org.] Statutes')
        ->attach($file)
        ->send();
    }

    /**
     * Mail sended if User lost activation mail/link or that action token is out
     * @param type $user
     * @param type $token
     */
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
    
    /**
     * Mail sended if User ask for resetting his account password
     * @param type $user
     * @param type $token
     */
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
