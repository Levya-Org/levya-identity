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

use yii\log\Logger;

/**
 * RBAC Role Helper/Wrapper
 * @author Hervé
 */
class RoleHelper {
    
    const ROLE_DEVELOPER = "developer";
    const ROLE_ADMINISTRATOR = "administrator";
    const ROLE_MEMBER = "member";
    const ROLE_USER = "USER";
    
    const ROLE_PROJECT_LEADER = "project.leader";
    const ROLE_PROJECT_MEMBER = "project.member";
    const ROLE_PROJECT_GUEST = "project.guest";
    
    /**
     * Return all Roles
     * @return array
     */
    public static function getRoles() {
        \Yii::getLogger()->log('getRoles', Logger::LEVEL_TRACE);
        return \Yii::$app->authManager->getRoles();
    }
    
    /**
     * Return all Roles assigned to a user
     * @param int $userId
     * @return array
     */
    public static function getUserRolesById($userId){
        \Yii::getLogger()->log('getUserRolesById:'.$userId, Logger::LEVEL_TRACE);
        return \Yii::$app->authManager->getRolesByUser($userId);
    }
    
    /**
     * Test if user is assigned to Role
     * @param int $userId
     * @param string $roleName
     * @return bool
     */
    public static function userHasRole($userId, $roleName){
        \Yii::getLogger()->log('userHasRole:'.$userId.':'.$roleName, Logger::LEVEL_TRACE);
        $userRoles = RoleHelper::getUserRolesById($userId);
        if(isset($userRoles)){
            return in_array($roleName, array_keys($userRoles));
        }
    }
}
