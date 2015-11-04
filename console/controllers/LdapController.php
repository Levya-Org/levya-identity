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

/**
 * Manage basic LDAP action.
 *
 * @author MATYSIAK Herve <herve.matysiak@viacesi.fr>
 */
class LdapController extends Controller {
    
    private function getOptions(){
        return [
            'host' => Param::getParamValue('ldap:host'),
            'port' => Param::getParamValue('ldap:port'),
            'username' => Param::getParamValue('ldap:username'),
            'bindRequiresDn' => Param::getParamValue('ldap:bindRequiresDn'),
            'baseDn' => Param::getParamValue('ldap:baseDn')
        ];
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
        $ldapPwd = Param::getParamValue('ldap:password');
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
}
