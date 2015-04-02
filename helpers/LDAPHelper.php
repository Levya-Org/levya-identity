<?php

namespace app\helpers;

use Zend\Ldap\Ldap;
use Zend\Ldap\Filter;

use Yii;
use yii\helpers\VarDumper;
use yii\log\Logger;

use app\models\Param;


/**
 * Description of LDAPHelper
 *
 * @author Hervé
 */
class LDAPHelper {    
    private static $_ldap = null;
    
    private static function getInstance(){
        if(self::$_ldap === null){
            self::$_ldap = new Ldap(self::getOptions());
            self::$_ldap->bind();            
        }
        return self::$_ldap;
    }
    
    private static function getOptions(){
        return [
            'host' => Param::getParamValue('ldap:host'),
            'username' => Param::getParamValue('ldap:username'),
            'password' => Param::getParamValue('ldap:password'),
            'bindRequiresDn' => Param::getParamValue('ldap:bindRequiresDn'),
            'baseDn' => Param::getParamValue('ldap:baseDn')
        ];
    }
    
    /**
     * Test if User exist in LDAP
     * $researchType 
     * => mail
     * => cn
     * => sn
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
                    '(&(objectclass=inetOrgPerson)(cn='.substr($param, 0, 40).'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            case 'uid':
            {
                $result = $ldap->search(
                    '(&(objectclass=inetOrgPerson)(uid='.substr($param, 40, 80).'))', "ou=user,dc=levya,dc=org", \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
                );
                break;
            }
            default:
                Yii::getLogger()->log('LDA¨PHelper : no researchType', Logger::LEVEL_ERROR);
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
            'cn' => substr($userLdapUid, 0, 40), //common name
            'uid' => substr($userLdapUid, 40, 80),
            'sn' => $userNickName, //surname
            'mail' => strtolower($userMail),
            'userPassword' => \Zend\Ldap\Attribute::createPassword($userPassword, \Zend\Ldap\Attribute::PASSWORD_HASH_SSHA),
            'displayName' => $userNickName,
            'objectClass' => 'inetOrgPerson',
        ];
        
        $ldap->add('uid='.substr($userLdapUid, 40, 80).',ou=user,dc=levya,dc=org', $array);
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
            $user = $ldap->getEntry('uid='.substr($ldapUID, 40, 80).',ou=user,dc=levya,dc=org');
            
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
            $ldap->update('uid='.substr($ldapUID, 40, 80).',ou=user,dc=levya,dc=org', $user);
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
        
        $user = $ldap->getEntry('uid='.substr($ldapUid, 40, 80).',ou=user,dc=levya,dc=org');
        
        if(!is_null($user) && array_key_exists('dn', $user))
            return $user['dn'];
        else
            return null;
    }
    
    /**
     * 
     * @param type $userDn
     * @param array $groups
     */
    public function addUserToGroup($userDn,array $groups){
        Yii::getLogger()->log('LDAPHelper:addUserToGroup', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
       
        foreach ($groups as $value) {
            $entry = $ldap->getEntry('cn='.$value.',ou=group,dc=levya,dc=org'); //SEE Perf if return all member.
            Yii::getLogger()->log('GROUP : '.$value.' UserDN : '.$userDn, Logger::LEVEL_WARNING);
            if(!is_null($entry)){
                \Zend\Ldap\Attribute::setAttribute($entry, 'member', $userDn, TRUE);
                $ldap->update('cn='.$value.',ou=group,dc=levya,dc=org', $entry);
            }
        }
    }
    
    /**
     * 
     * @param type $userDn
     * @param array $groups
     */
    public function removeUserToGroup($userDn,array $groups){
        Yii::getLogger()->log('LDAPHelper:removeUserToGroup', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
       
        foreach ($groups as $value) {
            $entry = $ldap->getEntry('cn='.$value.',ou=group,dc=levya,dc=org'); //SEE Perf if return all member.
            if(!is_null($entry)){
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
            if(!is_null($entry)){
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
            if(!is_null($entry)){
                \Zend\Ldap\Attribute::removeFromAttribute($entry, 'member', $userDn);
                $ldap->update('cn='.$value.',ou=access,dc=levya,dc=org', $entry);
            }
        }
    }
    
    //TODO
    public function checkAccessFromUser($userDn,array $access){
        Yii::getLogger()->log('LDAPHelper:checkAccessFromUser', Logger::LEVEL_TRACE);
        $ldap = $this->getInstance();
        
        $nbcount = 0;
        
        foreach ($access as $value) {
//            $result = $ldap->search(
//                '(&(objectclass=*)(member='.$userDn.'))', 'cn='.$value.',ou=access,dc=levya,dc=org', \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
//            );
            $result = $ldap->search(
                '(&(objectclass=inetOrgPerson)(memberOf=cn='.$value.',ou=access,dc=levya,dc=org))', 'cn='.$value.',ou=access,dc=levya,dc=org', \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE
            );
            if(isset($result)){
                $nbcount++;
            }
        }
        
        Yii::getLogger()->log('LDAPHelper:checkAccessFromUser $result:'.VarDumper::dumpAsString($result->toArray()), Logger::LEVEL_WARNING);
        
        if($nbcount/count($access) == 0)
            return true;
        else
            return false;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
//    protected function __construct()
//    {
//    }

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
