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

namespace common\models;

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;

use common\helpers\SystemHelper;

/**
 * ActionHistoryExt is used as a Helper for AtionHistory
 *
 * @author Hervé
 */
class ActionHistoryExt extends ActionHistory {
    const AH_USER_CREATION = 0;
    const AH_USER_RESEND = 1;
    const AH_USER_REGISTRATION = 2;
    const AH_USER_MEMBER_REGISTRATION = 3;
    const AH_USER_UPDATE = 4;   
    const AH_USER_RESET = 5;
    const AH_USER_CNIL_ACCESS = 6;

    const AH_USER_CONNECTION_IDENTITY = 100;
    const AH_USER_TRYCONNECTION_IDENTITY = 101;
    const AH_USER_CONNECTION_WIKI = 110;
    const AH_USER_TRYCONNECTION_WIKI = 111;
    const AH_USER_CONNECTION_REDMINE = 120;
    const AH_USER_TRYCONNECTION_REDMINE = 121;
    const AH_USER_CONNECTION_CLOUD = 130;
    const AH_USER_TRYCONNECTION_CLOUD = 131;
    const AH_USER_CONNECTION_GITLAB = 140;
    const AH_USER_TRYCONNECTION_GITLAB = 141;
    const AH_USER_CONNECTION_STATUS = 150;
    const AH_USER_TRYCONNECTION_STATUS = 151;
    const AH_USER_CONNECTION_FORUM = 160;
    const AH_USER_TRYCONNECTION_FORUM = 161;
    const AH_USER_CONNECTION_WEB = 170;
    const AH_USER_TRYCONNECTION_WEB = 171; 
    
    /**
     * Create an ActionHistory for a User creation
     * @param type $userId
     */
    public static function ahUserCreation($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_CREATION, $userId);
    }
    
    /**
     * Create an ActionHistory for a User token resend
     * @param type $userId
     */
    public static function ahUserResend($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_RESEND, $userId);
    }
    
    /**
     * Create an ActionHistory for a User registration
     * @param type $userId
     */
    public static function ahUserRegistration($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_REGISTRATION, $userId);
    }
    
    /**
     * Create an ActionHistory for a User who update as member
     * @param type $userId
     */
    public static function ahUserMemberRegistration($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_MEMBER_REGISTRATION, $userId);
    }
    
    /**
     * Create an ActionHistory for a User password reset
     * @param type $userId
     */
    public static function ahUserReset($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_RESET, $userId);
    }
    
    /**
     * Create an ActionHistory for a User update
     * @param type $userId
     */
    public static function ahUserUpdate($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_UPDATE, $userId);
    }
    
    /**
     * Create an ActionHosptry when User view raw data
     * @param type $userId
     */
    public static function ahUserCNILAccess($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistoryExt::AH_USER_CNIL_ACCESS, $userId);
    }
    
    /**
     * Create an ActionHistory for a Loging.
     * @param type $userId
     * @param SystemHelper $system
     */
    public static function ahUserConnection($userId, $system){
        $ac = new ActionHistory();
        switch ($system){
            case 'IDENTITY':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_IDENTITY, $userId);
                break;
            case 'WIKI':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_WIKI, $userId);
                break;
            case 'REDMINE':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_REDMINE, $userId);
                break;
            case 'CLOUD':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_CLOUD, $userId);
                break;
            case 'GITLAB':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_GITLAB, $userId);
                break;
            case 'STATUS':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_STATUS, $userId);
                break;
            case 'FORUM':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_FORUM, $userId);
                break;
            case 'WEB':
                $ac->create(ActionHistoryExt::AH_USER_CONNECTION_WEB, $userId);
                break;
            default:
                Yii::getLogger()->log('ActionHistoryExt no or unknow system specified : '.VarDumper::dumpAsString($system), Logger::LEVEL_ERROR);
                break;
        }
    }
    
    /**
     * Create a ActionHistory for a False Loging.
     * @param type $userId
     * @param SystemHelper $system
     */
    public static function ahUserTriedConnection($userId, $system){
        $ac = new ActionHistory();
        switch ($system){
            case 'IDENTITY':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_IDENTITY, $userId);
                break;
            case 'WIKI':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_WIKI, $userId);
                break;
            case 'REDMINE':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_REDMINE, $userId);
                break;
            case 'CLOUD':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_CLOUD, $userId);
                break;
            case 'GITLAB':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_GITLAB, $userId);
                break;
            case 'STATUS':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_STATUS, $userId);
                break;
            case 'FORUM':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_FORUM, $userId);
                break;
            case 'WEB':
                $ac->create(ActionHistoryExt::AH_USER_TRYCONNECTION_WEB, $userId);
                break;
            default:
                Yii::getLogger()->log('ActionHistoryExt no or unknow system specified : '.VarDumper::dumpAsString($system), Logger::LEVEL_ERROR);
                break;
        }
    }
    
    /**
     * Get the translation of ActionHistory
     * @param type $actionId
     * @return type
     */
    public static function actionIdtoStr($actionId){
        switch ($actionId) {
            case ActionHistoryExt::AH_USER_CREATION:
                return \Yii::t('app/actionhistory', 'AH_USER_CREATION');
                break;
            case ActionHistoryExt::AH_USER_RESEND:
                return \Yii::t('app/actionhistory', 'AH_USER_RESEND');
                break;
            case ActionHistoryExt::AH_USER_REGISTRATION:
                return \Yii::t('app/actionhistory', 'AH_USER_REGISTRATION');
                break;
            case ActionHistoryExt::AH_USER_MEMBER_REGISTRATION:
                return \Yii::t('app/actionhistory', 'AH_USER_MEMBER_REGISTRATION');
                break;
            case ActionHistoryExt::AH_USER_UPDATE:
                return \Yii::t('app/actionhistory', 'AH_USER_UPDATE');
                break;
            case ActionHistoryExt::AH_USER_RESET:
                return \Yii::t('app/actionhistory', 'AH_USER_RESET');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_IDENTITY:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_IDENTITY');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_IDENTITY:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_IDENTITY');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_WIKI:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_WIKI');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_WIKI:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_WIKI');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_REDMINE:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_REDMINE');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_REDMINE:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_REDMINE');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_CLOUD:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_CLOUD');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_CLOUD:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_CLOUD');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_GITLAB:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_GITLAB');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_GITLAB:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_GITLAB');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_STATUS:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_STATUS');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_STATUS:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_STATUS');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_FORUM:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_FORUM');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_FORUM:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_FORUM');
                break;
            case ActionHistoryExt::AH_USER_CONNECTION_WEB:
                return \Yii::t('app/actionhistory', 'AH_USER_CONNECTION_WEB');
                break;
            case ActionHistoryExt::AH_USER_TRYCONNECTION_WEB:
                return \Yii::t('app/actionhistory', 'AH_USER_TRYCONNECTION_WEB');
                break;
            default:
                Yii::getLogger()->log('ActionHistoryExt no or unknow ActionHistoryID specified : '.VarDumper::dumpAsString($actionId), Logger::LEVEL_WARNING);
                break;
        }        
    }
    
    
}
