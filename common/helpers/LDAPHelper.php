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

use Zend\Ldap\Ldap;

use Yii;
use yii\helpers\VarDumper;
use yii\log\Logger;

use common\models\Param;

/**
 * Description of LDAPHelper
 * 
 * User LDAP Struct : 
 * 'cn' | 'commonName' : Name
 * 'uid': UID
 * 'sn' | 'surname' : Last Name
 * 'gn' | 'givenName' : First Name
 * 'mail' : Mail 
 * 'userPassword' : Password
 * 'displayName' : NickName
 * 'objectClass' : 'inetOrgPerson',
 * 
 * @author Hervé
 */
class LDAPHelper {

    /**
     * Test if User exist in LDAP
     * $researchType
     * => sn
     * => displayName
     * => mail
     * => cn
     * => uid
     * @param type $researchType
     * @param type $param
     */
    public function testUserBy($researchType, $param){
        Yii::getLogger()->log('LDAPHelper:testUserBy', Logger::LEVEL_TRACE);

        $result = null;

        if(!isset($param)){
            Yii::getLogger()->log('LDAPHelper : no param '.VarDumper::dumpAsString($this->errors), Logger::LEVEL_ERROR);
            return false;
        }

        switch ($researchType){
            case 'sn':
            case 'surname':
            {
                $result = Yii::$app->ldap->search(
                    '(&(objectclass=inetOrgPerson)(sn='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'displayName':
            {
                $result = Yii::$app->ldap->search(
                    '(&(objectclass=inetOrgPerson)(displayName='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'mail':
            {
                $result = Yii::$app->ldap->search(
                    '(&(objectclass=inetOrgPerson)(mail='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'cn':
            case 'commonName':
            {
                $result = Yii::$app->ldap->search(
                    '(&(objectclass=inetOrgPerson)(cn='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'uid':
            {
                $result = Yii::$app->ldap->search(
                    '(&(objectclass=inetOrgPerson)(uid='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            default:
                Yii::getLogger()->log('LDAPHelper : no researchType', Logger::LEVEL_ERROR);
                return false;
        }

        if(!is_null($result)){
            $count = count($result);
            if($count >= 1)
                return true;
            else
                return false;
        }
        else {
            Yii::getLogger()->log('LDAPHelper : result is null', Logger::LEVEL_ERROR);
        }
        return false;
    }

    /**
     * Add user
     * @param type $userNickName
     * @param type $userMail
     * @param type $userPassword
     * @param type $userLdapUid
     * @return type
     */
    public function addUser($userNickName, $userMail, $userPassword, $userLdapUid){
        Yii::getLogger()->log('LDAPHelper:addUser', Logger::LEVEL_TRACE);

        if($this->testUserBy('mail', $userMail) || $this->testUserBy('displayName', $userNickName) || $this->testUserBy('sn', $userNickName)){
            Yii::getLogger()->log('LDAPHelper:addUser : user with same data exist', Logger::LEVEL_ERROR);
            return;
        }

        $array = [
            'cn' => $userNickName,
            'uid' => $userLdapUid,
            'sn' => $userNickName,
            'mail' => strtolower($userMail),
            'userPassword' => \Zend\Ldap\Attribute::createPassword($userPassword, \Zend\Ldap\Attribute::PASSWORD_HASH_SSHA),
            'displayName' => $userNickName,
            'objectClass' => 'inetOrgPerson',
        ];

        Yii::$app->ldap->add('uid='.$userLdapUid.',ou=user,dc=levya,dc=org', $array);
    }

    /**
     * Remove a user from LDAP (with memberOf dep.)
     * @param type $ldapUid
     */
    public function removeUser($ldapUid){
        Yii::getLogger()->log('LDAPHelper:removeUser', Logger::LEVEL_TRACE);

        $userDn = $this->getDNfromUser($ldapUid);

        if(isset($userDn))
            Yii::$app->ldap->delete($userDn);
        else
            Yii::getLogger()->log('LDAPHelper : Try to remove a inexistent user : LDAPUID : '.$ldapUid, Logger::LEVEL_WARNING);
    }

    /**
     * Update a user
     * @param type $ldapUID
     * @param array $params See Class details for param
     */
    public function updateUser($ldapUID,array $params){
        Yii::getLogger()->log('LDAPHelper:updateUser', Logger::LEVEL_TRACE);

        if($this->testUserBy('uid', $ldapUID)){
            $user = Yii::$app->ldap->getEntry('uid='.$ldapUID.',ou=user,dc=levya,dc=org');

            foreach ($params as $key => $value) {
                switch ($key){
                    case 'cn':
                    case 'commonName':
                    {
                        \Zend\Ldap\Attribute::setAttribute($user, 'cn', $value);
                        break;
                    }
                    case 'sn':
                    case 'surname':
                    {
                        \Zend\Ldap\Attribute::setAttribute($user, 'sn', $value);
                        break;
                    }
                    case 'gn':
                    case 'giveName':
                    {
                        \Zend\Ldap\Attribute::setAttribute($user, 'gn', $value);
                        break;
                    }
                    case 'mail':
                    {
                        \Zend\Ldap\Attribute::setAttribute($user, 'mail', $value);
                        break;
                    }
                    case 'userPassword':
                    {
                        \Zend\Ldap\Attribute::setAttribute($user, 'userPassword', \Zend\Ldap\Attribute::createPassword($value, \Zend\Ldap\Attribute::PASSWORD_HASH_SSHA));
                        break;
                    }
                    case 'displayName':
                    {
                        \Zend\Ldap\Attribute::setAttribute($user, 'displayName', $value);
                        break;
                    }
                    default:
                    {
                        Yii::getLogger()->log('LDAPHelper:updateUser updating a unknow user attr : '.$key.' with data : '.$value, Logger::LEVEL_WARNING);
                        break;
                    }
                }
            }
            Yii::$app->ldap->update('uid='.$ldapUID.',ou=user,dc=levya,dc=org', $user);
        }
    }

    /**
     * Return user DN if exist otherwise null
     * @param type $ldapUid
     * @return string | null
     */
    public function getDNfromUser($ldapUid){
        Yii::getLogger()->log('LDAPHelper:getDNfromUser', Logger::LEVEL_TRACE);

        $user = Yii::$app->ldap->getEntry('uid='.$ldapUid.',ou=user,dc=levya,dc=org');

        if(!is_null($user) && array_key_exists('dn', $user))
            return $user['dn'];
        else
            return null;
    }

    /**
     * Add User to Group
     * @param type $userDn
     * @param array $groups
     */
    public function addUserToGroup($userDn,array $groups){
        Yii::getLogger()->log('LDAPHelper:addUserToGroup', Logger::LEVEL_TRACE);

        foreach ($groups as $value) {
            $entry = Yii::$app->ldap->getEntry('cn='.$value.',ou=group,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && !\Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::setAttribute($entry, 'member', $userDn, TRUE);
                Yii::$app->ldap->update('cn='.$value.',ou=group,dc=levya,dc=org', $entry);
            }
        }
    }

    /**
     * Remove User from Group
     * @param type $userDn
     * @param array $groups
     */
    public function removeUserToGroup($userDn,array $groups){
        Yii::getLogger()->log('LDAPHelper:removeUserToGroup', Logger::LEVEL_TRACE);

        foreach ($groups as $value) {
            $entry = Yii::$app->ldap->getEntry('cn='.$value.',ou=group,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && \Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::removeFromAttribute($entry, 'member', $userDn);
                Yii::$app->ldap->update('cn='.$value.',ou=group,dc=levya,dc=org', $entry);
            }
        }
    }

    /**
     * Add user member attr. in a groupOfName
     * $userDn is the full user dn
     * $access is an array of cn of accccess group
     * @param type $userDn
     * @param array $access
     */
    public function addUserToAccess($userDn,array $access){
        Yii::getLogger()->log('LDAPHelper:addUserToAccess', Logger::LEVEL_TRACE);

        foreach ($access as $value) {
            $entry = Yii::$app->ldap->getEntry('cn='.$value.',ou=access,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && !\Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::setAttribute($entry, 'member', $userDn, TRUE);
                Yii::$app->ldap->update('cn='.$value.',ou=access,dc=levya,dc=org', $entry);
            }
        }
    }

    /**
     * Remove user member attr. in a groupOfName
     * $userDn is the full user dn
     * $access is an array of cn of accccess group
     * @param type $userDn
     * @param array $access
     */
    public function removeUserToAccess($userDn,array $access){
        Yii::getLogger()->log('LDAPHelper:removeUserToAccess', Logger::LEVEL_TRACE);

        foreach ($access as $value) {
            $entry = Yii::$app->ldap->getEntry('cn='.$value.',ou=access,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && \Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::removeFromAttribute($entry, 'member', $userDn);
                Yii::$app->ldap->update('cn='.$value.',ou=access,dc=levya,dc=org', $entry);
            }
        }
    }

    /**
     * Check if User has access to (Levya) access with his LDAPUID
     * @param type $userLdapUid
     * @param type $accessName
     * @return boolean
     */
    public function checkAccessFromUser($userLdapUid,$accessName){
        Yii::getLogger()->log('LDAPHelper:checkAccessFromUser', Logger::LEVEL_TRACE);

        $result = Yii::$app->ldap->search(
            '(&(objectClass=inetOrgPerson)(uid='.$userLdapUid.')(memberOf=cn='.$accessName.',ou=access,dc=levya,dc=org))', 'ou=user,dc=levya,dc=org', \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB, array('memberOf')
        );

        $nbResult = $result->count();

        if( $nbResult > 0 && (count($result->toArray()[0]['memberof']) >= 1)){
            return true;
        }
        else
            return false;
    }

    /**
     * Check if User is in Group with his LDAPUID
     * @param type $userLdapUid
     * @param type $groupName
     * @return boolean
     */
    public function checkGroupFromUser($userLdapUid, $groupName){
        Yii::getLogger()->log('LDAPHelper:checkGroupFromUser', Logger::LEVEL_TRACE);

        $result = Yii::$app->ldap->search(
            '(&(objectClass=inetOrgPerson)(uid='.$userLdapUid.')(memberOf=cn='.$groupName.',ou=group,dc=levya,dc=org))', 'ou=user,dc=levya,dc=org', \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB, array('memberOf')
        );

        $nbResult = $result->count();

        if( $nbResult > 0 && (count($result->toArray()[0]['memberof']) >= 1)){
            return true;
        }
        else
            return false;
    }

    /**
     * Test if connection info. are right.
     * @return boolean
     */
    public function checkConnection(){
        Yii::getLogger()->log('LDAPHelper:checkConnection', Logger::LEVEL_TRACE);
        try {
            return true;
        } catch (\Zend\Ldap\Exception\LdapException $exc) {
            return false;
        } catch (\Exception $exc) {
            Yii::getLogger()->log("Error at connection : ".VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            return false;
        }
    }
}
