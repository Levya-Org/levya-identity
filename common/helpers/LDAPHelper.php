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
 * @author Hervé
 */
class LDAPHelper {
    /** @var Zend\Ldap\Ldap */
    private static $_ldap = null;
    
    /**
     * Get the (Zend) LDAP instance
     * @return Zend\Ldap\Ldap
     */
    private static function getInstance(){
        if(self::$_ldap === null){
            self::$_ldap = new Ldap(self::getOptions());
            self::$_ldap->bind();            
        }
        return self::$_ldap;
    }
    
    /**
     * Return connection param. for LDAP.
     * @return array
     */
    private static function getOptions(){
        return [
            'host' => Param::getParamValue('ldap:host'),
            'port' => Param::getParamValue('ldap:port'),
            'username' => Param::getParamValue('ldap:username'),
            'password' => Param::getParamValue('ldap:password'),
            'bindRequiresDn' => Param::getParamValue('ldap:bindRequiresDn'),
            'baseDn' => Param::getParamValue('ldap:baseDn')
        ];
    }
    
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
        
        $ldap = $this->getInstance();
        $result = null;
        
        if(!isset($param)){
            Yii::getLogger()->log('LDAPHelper : no param '.VarDumper::dumpAsString($this->errors), Logger::LEVEL_ERROR);
            return false;
        }
        
        switch ($researchType){
            case 'sn':
            {
                $result = $ldap->search(
                    '(&(objectclass=inetOrgPerson)(sn='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'displayName':
            {
                $result = $ldap->search(
                    '(&(objectclass=inetOrgPerson)(displayName='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'mail':
            {
                $result = $ldap->search(
                    '(&(objectclass=inetOrgPerson)(mail='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'cn':
            {
                $result = $ldap->search(
                    '(&(objectclass=inetOrgPerson)(cn='.$param.'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'uid':
            {
                $result = $ldap->search(
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
        
        $ldap = $this->getInstance();
        //TODO: see how to store what 
        $array = [
            'cn' => $userLdapUid, //tmp common name
            'uid' => $userLdapUid,
            'sn' => $userNickName, //surname
            'mail' => strtolower($userMail),
            'userPassword' => \Zend\Ldap\Attribute::createPassword($userPassword, \Zend\Ldap\Attribute::PASSWORD_HASH_SSHA),
            'displayName' => $userNickName,
            'objectClass' => 'inetOrgPerson',
        ];
        
        $ldap->add('uid='.$userLdapUid.',ou=user,dc=levya,dc=org', $array);
    }
    
    /**
     * Remove a user from LDAP (with memberOf dep.)
     * @param type $ldapUid
     */
    public function removeUser($ldapUid){
        Yii::getLogger()->log('LDAPHelper:removeUser', Logger::LEVEL_TRACE);
        
        $ldap = $this->getInstance();
        
        $userDn = $this->getDNfromUser($ldapUid);
        
        if(isset($userDn))       
            $ldap->delete($userDn);
        else
            Yii::getLogger()->log('LDAPHelper : Try to remove a inexistent user : LDAPUID : '.$ldapUid, Logger::LEVEL_WARNING);
    }
    
    /**
     * Update a user
     * @param type $ldapUID
     * @param array $params like Yii2 array
     */
    public function updateUser($ldapUID,array $params){
        Yii::getLogger()->log('LDAPHelper:updateUser', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
        
        if($this->testUserBy('uid', $ldapUID)){
            $user = $ldap->getEntry('uid='.$ldapUID.',ou=user,dc=levya,dc=org');
            
            foreach ($params as $key => $value) {
                switch ($key){
                   case 'sn':
                   {
                       \Zend\Ldap\Attribute::setAttribute($user, 'sn', $value);
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
            $ldap->update('uid='.$ldapUID.',ou=user,dc=levya,dc=org', $user);
        }
    }
    
    /**
     * Return user DN if exist otherwise null
     * @param type $ldapUid
     * @return string | null
     */
    public function getDNfromUser($ldapUid){
        Yii::getLogger()->log('LDAPHelper:getDNfromUser', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
        
        $user = $ldap->getEntry('uid='.$ldapUid.',ou=user,dc=levya,dc=org');
        
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
        $ldap = $this->getInstance();
       
        foreach ($groups as $value) {
            $entry = $ldap->getEntry('cn='.$value.',ou=group,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && !\Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::setAttribute($entry, 'member', $userDn, TRUE);
                $ldap->update('cn='.$value.',ou=group,dc=levya,dc=org', $entry);               
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
        $ldap = $this->getInstance();
       
        foreach ($groups as $value) {
            $entry = $ldap->getEntry('cn='.$value.',ou=group,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && \Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::removeFromAttribute($entry, 'member', $userDn);
                $ldap->update('cn='.$value.',ou=group,dc=levya,dc=org', $entry);
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
        $ldap = $this->getInstance();
       
        foreach ($access as $value) {
            $entry = $ldap->getEntry('cn='.$value.',ou=access,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && !\Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::setAttribute($entry, 'member', $userDn, TRUE);
                $ldap->update('cn='.$value.',ou=access,dc=levya,dc=org', $entry);
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
        $ldap = $this->getInstance();
       
        foreach ($access as $value) {
            $entry = $ldap->getEntry('cn='.$value.',ou=access,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry) && \Zend\Ldap\Attribute::attributeHasValue($entry, 'member', $userDn)){
                \Zend\Ldap\Attribute::removeFromAttribute($entry, 'member', $userDn);
                $ldap->update('cn='.$value.',ou=access,dc=levya,dc=org', $entry);
            }
        }
    }
    
    /**
     * Check if User has access to (Levya) access with his LDAPUID
     * @param type $ldapId
     * @param array $access
     * @return boolean
     */
    public function checkAccessFromUser($ldapId,array $access){
        Yii::getLogger()->log('LDAPHelper:checkAccessFromUser', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
        
        $nbcount = 0;
        
        foreach ($access as $value) {            
            $result = $ldap->search(
                '(&(objectClass=inetOrgPerson)(uid='.$ldapId.')(memberOf=cn='.$value.',ou=access,dc=levya,dc=org))', 'ou=user,dc=levya,dc=org', \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB, array('memberOf')
            );
            
            $nbResult = $result->count();

            if( $nbResult > 0 && (count($result->toArray()[0]['memberof']) >= 1)){
                $nbcount++;
            }
        }
        
        if($nbcount/count($access) == 1)
            return true;
        else
            return false;
    }
    
    /**
     * Check if User is in Group with his LDAPUID
     * @param type $ldapId
     * @param array $group
     * @return boolean
     */
    public function checkGroupFromUser($ldapId,array $group){
        Yii::getLogger()->log('LDAPHelper:checkGroupFromUser', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
        
        $nbcount = 0;
        
        foreach ($group as $value) {            
            $result = $ldap->search(
                '(&(objectClass=inetOrgPerson)(uid='.$ldapId.')(memberOf=cn='.$value.',ou=group,dc=levya,dc=org))', 'ou=user,dc=levya,dc=org', \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB, array('memberOf')
            );
            
            $nbResult = $result->count();

            if( $nbResult > 0 && (count($result->toArray()[0]['memberof']) >= 1)){
                $nbcount++;
            }
        }
        
        if($nbcount/count($group) == 1)
            return true;
        else
            return false;
    }
    
    /**
     * Test if connection info. are right.
     * @return boolean
     */
    public function checkConnection(){
        try {
            $ldap = $this->getInstance();
            return true;
        } catch (\Zend\Ldap\Exception\LdapException $exc) {
            return false;
        } catch (\Exception $exc) {
            Yii::getLogger()->log("Error at connection : ".VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
            return false;
        }
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}
