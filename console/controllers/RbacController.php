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
 * Copyright (C) Roman Revin <xgismox@gmail.com>
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\log\Logger;

use common\models\User;
/**
 * Manage RBAC of application.
 *
 * @author Hervé
 */
class RbacController extends Controller
{
    /** @var \yii\db\Connection */
    private $db;
    
    /**
     * @throws \yii\base\InvalidConfigException
     * @return \yii\rbac\DbManager
     * @author Roman Revin <xgismox@gmail.com>
     */
    protected function getAuthManagerComponent()
    {
        $authManager = \Yii::$app->get('authManager');
        if (!$authManager instanceof \yii\rbac\BaseManager) {
            throw new \yii\base\InvalidConfigException(
                sprintf('You should configure "%s" component before executing this command.', 'authManager')
            );
        }
        return $authManager;
    }
    
    /**
     * Init RBAC 
     */
    public function actionInit()
    {
        $auth = $this->getAuthManagerComponent();
        $useTransaction = $auth instanceof \yii\rbac\DbManager;
        $transaction = null;
        if ($useTransaction) {
            $this->db = \yii\di\Instance::ensure($auth->db, \yii\db\Connection::className());
            $transaction = $this->db->beginTransaction();
        }
        
        try {
            //PERMISSIONS
            $perms = array();
            //ActionHistory
            $perms[] = $AH_create = $auth->createPermission('create.actionhistory');
            $perms[] = $AH_update = $auth->createPermission('update.actionhistory');
            $perms[] = $AH_delete = $auth->createPermission('delete.actionhistory');
            $perms[] = $AH_read = $auth->createPermission('read.actionhistory');
            $perms[] = $AH_read_own = $auth->createPermission('read:own.actionhistory');

    //        $AH_read_own_rule = new \app\rbac\AhReadOwnRule;
    //        $auth->add($AH_read_own_rule);
    //        $AH_read_own->ruleName = $AH_read_own_rule->name;

            //UserState
            $perms[] = $US_create = $auth->createPermission('create.userstate');
            $perms[] = $US_update = $auth->createPermission('update.userstate');
            $perms[] = $US_delete = $auth->createPermission('delete.userstate');
            $perms[] = $US_read = $auth->createPermission('read.userstate');

            //Token
            $perms[] = $TK_create = $auth->createPermission('create.token');
            $perms[] = $TK_update = $auth->createPermission('update.token');
            $perms[] = $TK_delete = $auth->createPermission('delete.token');
            $perms[] = $TK_read = $auth->createPermission('read.token');

            //SocialAccount
            $perms[] = $SA_create = $auth->createPermission('create.socialaccount');
            $perms[] = $SA_update = $auth->createPermission('update.socialaccount');
            $perms[] = $SA_delete = $auth->createPermission('delete.socialaccount');
            $perms[] = $SA_read = $auth->createPermission('read.socialaccount');

            //Country
            $perms[] = $CT_create = $auth->createPermission('create.country');
            $perms[] = $CT_update = $auth->createPermission('update.country');
            $perms[] = $CT_delete = $auth->createPermission('delete.country');
            $perms[] = $CT_read = $auth->createPermission('read.country');

            //Donation
            //TODO : private donation ? unlisted ? 
            $perms[] = $DT_create = $auth->createPermission('create.donation');
            $perms[] = $DT_update = $auth->createPermission('update.donation');
            $perms[] = $DT_delete = $auth->createPermission('delete.donation');
            $perms[] = $DT_read = $auth->createPermission('read.donation');

            //Params
            $perms[] = $AP_create = $auth->createPermission('create.param');
            $perms[] = $AP_update = $auth->createPermission('update.param');
            $perms[] = $AP_delete = $auth->createPermission('delete.param');
            $perms[] = $AP_read = $auth->createPermission('read.param');

            //Event
            $perms[] = $ET_create = $auth->createPermission('create.event');
            $perms[] = $ET_update = $auth->createPermission('update.event');
            $perms[] = $ET_delete = $auth->createPermission('delete.event');
            $perms[] = $ET_read = $auth->createPermission('read.event');

            //Event Type
            $perms[] = $ETT_create = $auth->createPermission('create.eventtype');
            $perms[] = $ETT_update = $auth->createPermission('update.eventtype');
            $perms[] = $ETT_delete = $auth->createPermission('delete.eventtype');
            $perms[] = $ETT_read = $auth->createPermission('read.eventtype');

            //Belong
            $perms[] = $BG_create = $auth->createPermission('create.belong');
            $perms[] = $BG_update = $auth->createPermission('update.belong');
            $perms[] = $BG_delete = $auth->createPermission('delete.belong');
            $perms[] = $BG_read = $auth->createPermission('read.belong');

            //Group
            $perms[] = $GP_create = $auth->createPermission('create.group');
            $perms[] = $GP_update = $auth->createPermission('update.group');
            $perms[] = $GP_delete = $auth->createPermission('delete.group');
            $perms[] = $GP_read = $auth->createPermission('read.group');

            //Service
            $perms[] = $SV_create = $auth->createPermission('create.service');
            $perms[] = $SV_update = $auth->createPermission('update.service');
            $perms[] = $SV_delete = $auth->createPermission('delete.service');
            $perms[] = $SV_read = $auth->createPermission('read.service');

            //Group Access Service
            $perms[] = $GAS_create = $auth->createPermission('create.groupaccessservice');
            $perms[] = $GAS_update = $auth->createPermission('update.groupaccessservice');
            $perms[] = $GAS_delete = $auth->createPermission('delete.groupaccessservice');
            $perms[] = $GAS_read = $auth->createPermission('read.groupaccessservice');

            //Project
            $perms[] = $PJ_create = $auth->createPermission('create.project');
            $perms[] = $PJ_update = $auth->createPermission('update.project');
            $perms[] = $PJ_update_own = $auth->createPermission('update:own.project');
            $perms[] = $PJ_delete = $auth->createPermission('delete.project');
            $perms[] = $PJ_delete_own = $auth->createPermission('delete:own.project');
            $perms[] = $PJ_read = $auth->createPermission('read.project');

            //Position
            $perms[] = $PS_create = $auth->createPermission('create.position');
            $perms[] = $PS_update = $auth->createPermission('update.position');
            $perms[] = $PS_update_ownProject = $auth->createPermission('update:project.position');
            $perms[] = $PS_delete = $auth->createPermission('delete.position');
            $perms[] = $PS_delete_ownProject = $auth->createPermission('delete:project.position');
            $perms[] = $PS_read = $auth->createPermission('read.position');

            //Wk
            $perms[] = $WK_create = $auth->createPermission('create.work');
            $perms[] = $WK_create_ownProject = $auth->createPermission('create:project.work');
            $perms[] = $WK_update = $auth->createPermission('update.work');
            $perms[] = $WK_update_own = $auth->createPermission('update:own.work');
            $perms[] = $WK_update_ownProject = $auth->createPermission('update:project.work');        
            $perms[] = $WK_delete = $auth->createPermission('delete.work');
            $perms[] = $WK_delete_own = $auth->createPermission('delete:own.work');
            $perms[] = $WK_delete_ownProject = $auth->createPermission('delete:project.work');
            $perms[] = $WK_read = $auth->createPermission('read.work');
            $perms[] = $WK_read_ownProject = $auth->createPermission('read:project.work');

            //Position Access Service
            $perms[] = $PAS_create = $auth->createPermission('create.positionaccessservice');
            $perms[] = $PAS_create_ownProject = $auth->createPermission('create:project.positionaccessservice');
            $perms[] = $PAS_update = $auth->createPermission('update.positionaccessservice');
            $perms[] = $PAS_update_ownProject = $auth->createPermission('update:project.positionaccessservice');
            $perms[] = $PAS_delete = $auth->createPermission('delete.positionaccessservice');
            $perms[] = $PAS_delete_ownProject = $auth->createPermission('delete:project.positionaccessservice');
            $perms[] = $PAS_read = $auth->createPermission('read.positionaccessservice');
            $perms[] = $PAS_read_ownProject = $auth->createPermission('read:project.positionaccessservice');

            //ADD PERMISSIONS
            Yii::getLogger()->log('Adding :'.  count($perms).' RBAC perms.', Logger::LEVEL_INFO);
            foreach ($perms as $perm) {
                $auth->add($perm);
            }
            $auth->addChild($AH_read_own, $AH_read);       
            $auth->addChild($PJ_update_own, $PJ_update);
            $auth->addChild($PJ_delete_own, $PJ_delete);
            $auth->addChild($PS_update_ownProject, $PS_update);
            $auth->addChild($PS_delete_ownProject, $PS_delete);
            $auth->addChild($WK_create_ownProject, $WK_create);
            $auth->addChild($WK_update_own, $WK_update);
            $auth->addChild($WK_update_ownProject, $WK_update);
            $auth->addChild($AH_read_own, $WK_delete);
            $auth->addChild($WK_delete_own, $WK_delete);
            $auth->addChild($WK_read_ownProject, $AH_read);
            $auth->addChild($PAS_create_ownProject, $PAS_create);
            $auth->addChild($PAS_update_ownProject, $PAS_update);
            $auth->addChild($PAS_delete_ownProject, $PAS_delete);
            $auth->addChild($PAS_read_ownProject, $PAS_read);

            //ROLES
            Yii::getLogger()->log('Adding RBAC roles.', Logger::LEVEL_INFO);
            $role_user = $auth->createRole('user');
            $role_member = $auth->createRole('member');
            $role_admin = $auth->createRole('administrator');
            $role_dev = $auth->createRole('developer');

            $role_projectLeader = $auth->createRole('project.leader');
            $role_projectMember = $auth->createRole('project.member');
            $role_projectGuest = $auth->createRole('project.guest');

            //ADD ROLES
            $auth->add($role_user);
            $auth->add($role_member);
            $auth->addChild($role_member, $role_user);
            $auth->add($role_admin);
    //        $auth->addChild($role_admin, $role_user); //NEEDED ?
            $auth->addChild($role_admin, $role_member);
            $auth->add($role_dev);
    //        $auth->addChild($role_dev, $role_user); //NEEDED ?
    //        $auth->addChild($role_dev, $role_member); //NEEDED ?
            $auth->addChild($role_dev, $role_admin);

            $auth->add($role_projectMember);
            $auth->add($role_projectLeader);
            $auth->addChild($role_projectLeader, $role_projectMember);

            //ROLES <> PERMISSIONS
            Yii::getLogger()->log('Adding RBAC roles <> perms link.', Logger::LEVEL_INFO);
            //ADD PERMISSION
            //USER
            $auth->addChild($role_user, $AH_read_own);
    //        $auth->addChild($role_user, $SA_create);
    //        $auth->addChild($role_user, $SA_update);
    //        $auth->addChild($role_user, $SA_delete);
    //        $auth->addChild($role_user, $SA_read);
            $auth->addChild($role_user, $DT_create);
            $auth->addChild($role_user, $DT_read);
            $auth->addChild($role_user, $ET_read);
            $auth->addChild($role_user, $PJ_read);
            //MEMBER
            $auth->addChild($role_member, $PJ_create);
            $auth->addChild($role_member, $WK_create); //Aksk to work for
            $auth->addChild($role_member, $WK_update_own); //Update his position 
            $auth->addChild($role_member, $WK_delete_own); //Resign ti work for project
            //ADMIN
            $auth->addChild($role_admin, $AH_read);
            $auth->addChild($role_admin, $US_create);
            $auth->addChild($role_admin, $US_update);
            $auth->addChild($role_admin, $US_read);
            $auth->addChild($role_admin, $TK_read);
            $auth->addChild($role_admin, $SA_read);
            $auth->addChild($role_admin, $CT_create);
            $auth->addChild($role_admin, $CT_update);
            $auth->addChild($role_admin, $CT_read);
            $auth->addChild($role_admin, $DT_update);
            $auth->addChild($role_admin, $AP_update);
            $auth->addChild($role_admin, $AP_read);
            $auth->addChild($role_admin, $ET_create);
            $auth->addChild($role_admin, $ET_update);
            $auth->addChild($role_admin, $ET_delete);
            $auth->addChild($role_admin, $ETT_create);
            $auth->addChild($role_admin, $ETT_update);
            $auth->addChild($role_admin, $ETT_read);
            $auth->addChild($role_admin, $ETT_delete);
            $auth->addChild($role_admin, $BG_create);
            $auth->addChild($role_admin, $BG_update);
            $auth->addChild($role_admin, $BG_read);
            $auth->addChild($role_admin, $BG_delete); //Banned user ? <> UserStates
            $auth->addChild($role_admin, $GP_create);
            $auth->addChild($role_admin, $GP_update);
            $auth->addChild($role_admin, $GP_delete);
            $auth->addChild($role_admin, $GP_read);
            $auth->addChild($role_admin, $SV_create);
            $auth->addChild($role_admin, $SV_update);
            $auth->addChild($role_admin, $SV_delete);
            $auth->addChild($role_admin, $SV_read);
            $auth->addChild($role_admin, $GAS_create);
            $auth->addChild($role_admin, $GAS_update);
            $auth->addChild($role_admin, $GAS_delete);
            $auth->addChild($role_admin, $GAS_read);
            $auth->addChild($role_admin, $PJ_update);
            $auth->addChild($role_admin, $PJ_delete);
            $auth->addChild($role_admin, $PS_update);
            $auth->addChild($role_admin, $PS_read);
            $auth->addChild($role_admin, $PS_delete);
            $auth->addChild($role_admin, $WK_update);
            $auth->addChild($role_admin, $WK_delete);
            $auth->addChild($role_admin, $WK_read);
            $auth->addChild($role_admin, $PAS_create);
            $auth->addChild($role_admin, $PAS_update);
            $auth->addChild($role_admin, $PAS_delete);
            $auth->addChild($role_admin, $PAS_read);
            //DEVELOPPER
            $auth->addChild($role_dev, $AH_create);
            $auth->addChild($role_dev, $AH_update);
            $auth->addChild($role_dev, $AH_delete);
            $auth->addChild($role_dev, $US_delete);
            $auth->addChild($role_dev, $TK_create);
            $auth->addChild($role_dev, $TK_update);
            $auth->addChild($role_dev, $TK_delete);
            $auth->addChild($role_dev, $CT_delete);
            $auth->addChild($role_dev, $DT_delete);
            $auth->addChild($role_dev, $AP_create);
            $auth->addChild($role_dev, $AP_delete);

            //PROJECT
            //LEADER
            $auth->addChild($role_projectLeader, $PJ_update_own);
            $auth->addChild($role_projectLeader, $PJ_delete_own);
            $auth->addChild($role_projectLeader, $PS_create);
            $auth->addChild($role_projectLeader, $PS_update_ownProject);
            $auth->addChild($role_projectLeader, $PS_delete_ownProject);
            $auth->addChild($role_projectLeader, $WK_create_ownProject);
            $auth->addChild($role_projectLeader, $WK_update_ownProject);
            $auth->addChild($role_projectLeader, $WK_delete_ownProject);
            $auth->addChild($role_projectLeader, $WK_read_ownProject);
            $auth->addChild($role_projectLeader, $PAS_create_ownProject);
            $auth->addChild($role_projectLeader, $PAS_update_ownProject);
            $auth->addChild($role_projectLeader, $PAS_delete_ownProject);
            $auth->addChild($role_projectLeader, $PAS_read_ownProject);
            
            if ($transaction !== null) {
                $transaction->commit();
            }
            
            $this->stdout("All RBAC data have been initialized.", Console::BG_GREEN);
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            
            if ($transaction !== null) {
                $transaction->rollBack();
            }
            
            return Controller::EXIT_CODE_ERROR;
        }
        return Controller::EXIT_CODE_NORMAL;
    }
    
    /**
     * Removes all authorization data, roles, permissions, rules, assignments.
     */
    public function actionClear(){
        $auth = $this->getAuthManagerComponent();
        $useTransaction = $auth instanceof \yii\rbac\DbManager;
        $transaction = null;
        if ($useTransaction) {
            $this->db = \yii\di\Instance::ensure($auth->db, \yii\db\Connection::className());
            $transaction = $this->db->beginTransaction();
        }
        
        try {
            if(Console::confirm("Are you sure ?")){
                Yii::getLogger()->log('[actionClear]::Begin of deleting', Logger::LEVEL_INFO);
                $auth->removeAll();
                Yii::getLogger()->log('[actionClear]::End of deleting', Logger::LEVEL_INFO);
                
                if ($transaction !== null) {
                    $transaction->commit();
                }
                
                $this->stdout("All RBAC data have been deleted.", Console::BG_GREEN);
            }            
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            
            if ($transaction !== null) {
                $transaction->rollBack();
            }
            
            return Controller::EXIT_CODE_ERROR;
        }        
        return Controller::EXIT_CODE_NORMAL;
    }
    
    /**
     * Assign role to user(s)
     * @param array $userId User DB ID
     * @param type $role RoleName : 
     */
    public function actionAssign(array $userId, $roleName){
        if(!isset($roleName) || trim($roleName)===''){
            throw new Exception("No role given.");
        }
        
        if(!isset($userId) && count($userId) <= 0){
            throw new Exception("No user(s) given.");
        }
        
        $auth = $this->getAuthManagerComponent();
        $useTransaction = $auth instanceof \yii\rbac\DbManager;
        $transaction = null;
        if ($useTransaction) {
            $this->db = \yii\di\Instance::ensure($auth->db, \yii\db\Connection::className());
            $transaction = $this->db->beginTransaction();
        }
        
        try {
            foreach ($userId as $id) {
                if(User::findOne($id) == NULL){
                    throw new Exception("User not found ID : ".$id);
                }
            }
            
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($roleName);
            
            if($role == null){
                throw new Exception("Role not found : ".$roleName);
            }
            
            foreach ($userId as $id) {
                $auth->assign($role, $id);
            }
            
            if ($transaction !== null) {
                $transaction->commit();
            }
            
            $this->stdout(count($userId)." user(s) have been assigned as : ".$role->name, Console::BG_GREEN);
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            
            if ($transaction !== null) {
                $transaction->rollBack();
            }
            
            return Controller::EXIT_CODE_ERROR;
        }        
        return Controller::EXIT_CODE_NORMAL;
    }
    
    /**
     * Revoke role from user(s)
     * @param array $userId User DB ID
     * @param type $role RoleName : 
     */
    public function actionRevoke(array $userId, $roleName){
        if(!isset($roleName) || trim($roleName)===''){
            throw new Exception("No role given.");
        }
        
        if(!isset($userId) && count($userId) <= 0){
            throw new Exception("No user(s) given.");
        }
        
        $auth = $this->getAuthManagerComponent();
        $useTransaction = $auth instanceof \yii\rbac\DbManager;
        $transaction = null;
        if ($useTransaction) {
            $this->db = \yii\di\Instance::ensure($auth->db, \yii\db\Connection::className());
            $transaction = $this->db->beginTransaction();
        }
        
        try {
            foreach ($userId as $id) {
                if(User::findOne($id) == NULL){
                    throw new Exception("User not found ID : ".$id);
                }
            }
            
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($roleName);
            
            if($role == null){
                throw new Exception("Role not found : ".$roleName);
            }
            
            foreach ($userId as $id) {
                $auth->revoke($role, $id);
            }
            
            if ($transaction !== null) {
                $transaction->commit();
            }
            
            $this->stdout(count($userId)." user(s) have been revoked from role : ".$role->name, Console::BG_GREEN);
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            
            if ($transaction !== null) {
                $transaction->rollBack();
            }
            
            return Controller::EXIT_CODE_ERROR;
        }        
        return Controller::EXIT_CODE_NORMAL;
    }
    
    /**
     * Display all Roles.
     */
    public function actionGetRoles(){
        try {
            $auth = \Yii::$app->authManager;
            foreach ($auth->getRoles() as $role) {
                $this->stdout($role->name.PHP_EOL);
            }
        } catch (Exception $exc) {
            \Yii::getLogger()->log(VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            $this->stderr($exc->getMessage(), Console::BG_RED);
            return Controller::EXIT_CODE_ERROR;
        }
        return Controller::EXIT_CODE_NORMAL;
    }
}
