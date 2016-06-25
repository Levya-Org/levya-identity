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

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\log\Logger;

use common\helpers\LDAPHelper;
use common\models\Param;
use common\models\User;
use common\models\Service;
use common\models\Group;

/**
 * Manage basic LDAP action.
 *
 * @author MATYSIAK Herve <herve.matysiak@viacesi.fr>
 */
class LdapController extends Controller {
    
    private function getOptions(){
        return  Yii::$app->ldap->config;
    }
    
    /**
     * Display info. about LDAP connection param.
     */
    public function actionInfo(){
        $this->stdout("LDAP Options :".PHP_EOL, Console::OVERLINED, Console::FG_YELLOW);
        Console::output(VarDumper::dumpAsString($this->getOptions()));
        $this->stdout("LDAP Connection status :".PHP_EOL, Console::OVERLINED, Console::FG_YELLOW);
        
        $ldap = new LDAPHelper();
        if($ldap->checkConnection()){
            $this->stdout("Connection is OK.", Console::BG_GREEN);
            return Controller::EXIT_CODE_NORMAL;
        }
        else {
            $this->stderr("Connection is KO.", Console::BG_RED);
            return Controller::EXIT_CODE_ERROR;
        }
    }
    
    /**
     * Test given password with stored password
     * @param string $password
     * @return boolean
     * @throws Exception
     */
    public function actionTestPassword($password = null){
        $ldapPwd = Yii::$app->ldap->config['password'];
        if(is_bool($ldapPwd) && !$ldapPwd){
            throw new Exception("No LDAP is password set.");
        }
        
        if($password == null){
            $password = Console::input("Please enter password : ");
        }
        
        if($password === $ldapPwd){
            $this->stdout("Given password is same as in config.", Console::BG_GREEN);
            return Controller::EXIT_CODE_NORMAL;
        }
        else {
            $this->stderr("Given password isn't same as in config.", Console::BG_RED);
            return Controller::EXIT_CODE_ERROR;
        }
    }
    
    /**
     * Sync user service LDAP from DB
     * @param type $userId User DB ID
     * @throws Exception
     */
    public function actionSyncUserService($userId){
        Yii::getLogger()->log('LdapController:actionSyncUserService', Logger::LEVEL_TRACE);
        if(!isset($userId)){
            throw new Exception("No user given.");
        }
        
        $user = User::find()
                ->select(['USER_ID','USER_LDAPUID'])
                ->where(['USER_ID' => $userId])
                ->limit(1)
                ->one();
        
        if($user == NULL){
            throw new Exception("User not found ID : ".$userId);
        }
        
        try {
            $userServices = $user->getLDAPAccess();
            $allServices = Service::getLdapServices();
            $userdLdapUid = $user->USER_LDAPUID;
            $nbAdd = 0;
            $nbRem = 0;
            
            $serviceDeniedToUser = array_diff($allServices, $userServices);
            $serviceToAdd = array();
            $serviceToRemove = array();
            
            $ldap = new LDAPHelper();
            $userDn = $ldap->getDNfromUser($userdLdapUid);
            foreach ($allServices as $service) {
                $haveAccess = $ldap->checkAccessFromUser($userdLdapUid, $service);
                if($haveAccess && in_array($service, $serviceDeniedToUser)){
                    $serviceToRemove[] = $service;
                    $nbRem++;
                }
                else if(!$haveAccess && in_array($service, $userServices)) {
                    $serviceToAdd[] = $service;
                    $nbAdd++;
                }
            }
            
            if($nbAdd > 0){
                $ldap->addUserToAccess($userDn, $serviceToAdd);
            }
            if($nbRem > 0){
                $ldap->removeUserToAccess($userDn, $serviceToRemove);
            }
            
            $this->stdout("Service Sync done : ".$nbAdd." add and ".$nbRem." rem.", Console::BG_GREEN);            
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            return Controller::EXIT_CODE_ERROR;
        }        
        return Controller::EXIT_CODE_NORMAL;       
    }
    
    /**
     * Sync user group LDAP from DB
     * @param type $userId
     * @return type
     * @throws Exception
     */
    public function actionSyncUserGroup($userId){
        Yii::getLogger()->log('LdapController:actionSyncUserGroup', Logger::LEVEL_TRACE);
        if(!isset($userId)){
            throw new Exception("No user given.");
        }
        
        $user = User::find()
                ->select(['USER_ID','USER_LDAPUID'])
                ->where(['USER_ID' => $userId])
                ->limit(1)
                ->one();
        
        if($user == NULL){
            throw new Exception("User not found ID : ".$userId);
        }
        
        try {
            $userGroups = $user->getLDAPGroup();
            $allGroups = Group::getLdapGroups();
            $userdLdapUid = $user->USER_LDAPUID;
            $nbAdd = 0;
            $nbRem = 0;
            
            $groupDeniedToUser = array_diff($allGroups, $userGroups);
            $groupToAdd = array();
            $groupToRemove = array();
            
            $ldap = new LDAPHelper();
            $userDn = $ldap->getDNfromUser($userdLdapUid);
            foreach ($allGroups as $group) {
                $haveAccess = $ldap->checkGroupFromUser($userdLdapUid, $group);
                if($haveAccess && in_array($group, $groupDeniedToUser)){ 
                    $groupToRemove[] = $group;
                    $nbRem++;
                }
                else if(!$haveAccess && in_array($group, $userGroups)) {
                    $groupToAdd[] = $group;
                    $nbAdd++;
                }
            }
            
            if($nbAdd > 0){
                $ldap->addUserToGroup($userDn, $groupToAdd);
            }
            if($nbRem > 0){
                $ldap->removeUserToGroup($userDn, $groupToRemove);
            }
            
            $this->stdout("Group Sync done : ".$nbAdd." add and ".$nbRem." rem.", Console::BG_GREEN);            
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            return Controller::EXIT_CODE_ERROR;
        }        
        return Controller::EXIT_CODE_NORMAL;  
    }
    
    /**
     * Update user LDAP data from DB 
     * @param type $userId
     * @return type
     * @throws Exception
     */
    public function actionSyncUserData($userId){
        Yii::getLogger()->log('LdapController:actionSyncUserData', Logger::LEVEL_TRACE);
        if(!isset($userId)){
            throw new Exception("No user given.");
        }
        
        $user = User::find()
                ->select([
                    'USER_ID',
                    'USER_LDAPUID', 
                    'USER_LASTNAME',
                    'USER_FORNAME',
                    'USER_LASTNAME',
                    'USER_NICKNAME',
                    'USER_MAIL'
                        ])
                ->where(['USER_ID' => $userId])
                ->limit(1)
                ->one();
        
        if($user == NULL){
            throw new Exception("User not found ID : ".$userId);
        }
        
        try {
            $ldap = new LDAPHelper();          
            $userData = array();
            //!isset($question) || trim($question)===''
            if(isset($user->USER_LASTNAME) || !trim($user->USER_LASTNAME)==='')
                $userData['sn'] = $user->USER_LASTNAME;
            if(isset($user->USER_FORNAME) || !trim($user->USER_FORNAME)==='') 
                $userData['gn'] = $user->USER_FORNAME;
            if((isset($user->USER_FORNAME) || !trim($user->USER_FORNAME)==='')
                    && (isset($user->USER_LASTNAME) || !trim($user->USER_LASTNAME)===''))
                $userData['cn'] = strtoupper($user->USER_LASTNAME)." ".ucfirst($user->USER_FORNAME);
            
            if(isset($user->USER_MAIL)) $userData['mail'] = $user->USER_MAIL;
            if(isset($user->USER_NICKNAME)) $userData['displayName'] = $user->USER_NICKNAME;
            
            $ldap->updateUser($user->USER_LDAPUID, $userData);
            
            $this->stdout("User data sync done.", Console::BG_GREEN);            
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            return Controller::EXIT_CODE_ERROR;
        }        
        return Controller::EXIT_CODE_NORMAL;
    }
}
