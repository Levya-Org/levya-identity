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

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;

use app\helpers\SystemHelper;

/**
 * ActionHistoryExt is used as a Helper for AtionHistory
 *
 * @author Hervé
 */
class ActionHistoryExt extends \app\models\ActionHistory{
    const AH_USER_CREATION = 0;
    const AH_USER_RESEND = 1;
    const AH_USER_REGISTRATION = 2;
    const AH_USER_UPDATE = 3;   
    const AH_USER_RESET = 4;

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
        $ac->create(ActionHistory::AH_USER_CREATION, $userId);
    }
    
    /**
     * Create an ActionHistory for a User token resend
     * @param type $userId
     */
    public static function ahUserResend($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistory::AH_USER_RESEND, $userId);
    }
    
    /**
     * Create an ActionHistory for a User registration
     * @param type $userId
     */
    public static function ahUserRegistration($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistory::AH_USER_REGISTRATION, $userId);
    }
    
    /**
     * Create an ActionHistory for a User password reset
     * @param type $userId
     */
    public static function ahUserReset($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistory::AH_USER_RESET, $userId);
    } 
    
    /**
     * Create an ActionHistory for a Loging.
     * @param type $userId
     * @param SystemHelper $system
     */
    public static function ahUserConnection($userId, SystemHelper $system){
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
     * Create a ActionHistory for a False Loging.
     * @param type $userId
     * @param SystemHelper $system
     */
    public static function ahUserTriedConnection($userId, SystemHelper $system){
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
     * Create an ActionHistory for a User update
     * @param type $userId
     */
    public static function ahUserUpdate($userId){
        $ac = new ActionHistory();
        $ac->create(ActionHistory::AH_USER_UPDATE, $userId);
    }
}
