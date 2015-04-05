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

namespace app\models;

use yii\base\Model;
use yii\log\Logger;
use app\models\User;
use app\models\ActionHistoryExt;
use common\helpers\LDAPHelper;

use common\helpers\PasswordHelper;
use kartik\password\StrengthValidator;

/**
 * Description of ProfileForm_Update
 *
 * @author Hervé
 */
class ProfileForm_Update extends User 
{   
    public $TMP_PASSWORD_VERIFY;
    public $USER_PASSWORD_VERIFY;
    
    public function rules()
    {
        return array_merge(User::rules(), [
            [['USER_PASSWORD_VERIFY'], 'required'],
            [['USER_PASSWORD_VERIFY'], 'validatePassword'],
            [['TMP_PASSWORD'], StrengthValidator::className(), 'preset'=>'fair', 'userAttribute'=>'USER_NICKNAME'],            
            ['TMP_PASSWORD_VERIFY', 'compare', 'compareAttribute' => 'TMP_PASSWORD'],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return array_merge(User::scenarios(), [
            'user_settings'   => ['USER_NICKNAME', 'USER_MAIL', 'TMP_PASSWORD', 'TMP_PASSWORD_VERIFY', 'USER_PASSWORD_VERIFY'],
            'user_AsMember_settings' => ['USER_LASTNAME', 'USER_FORNAME', 'USER_NICKNAME', 'USER_MAIL', 'TMP_PASSWORD', 'USER_ADDRESS', 'USER_PHONE', 'TMP_PASSWORD_VERIFY', 'USER_PASSWORD_VERIFY'],
        ]);                    
    }
    
    /** @inheritdoc */
    public function formName()
    {
        return 'profile-update-form';
    }
    
    public function updateProfile(){
        if($this->validate()){
            if(!(!isset($this->TMP_PASSWORD) || trim($this->TMP_PASSWORD)==='')){
                if($this->updatePassword()){
                    ActionHistoryExt::ahUserUpdate($this->USER_ID);
                    return true;
                }
            }
            
            if($this->update()){
                $ldap = new LDAPHelper();
                $ldap->updateUser($this->USER_LDAPUID, [
                    'mail' => $this->USER_MAIL,
                    'sn' => $this->USER_NICKNAME,
                    'displayName' => $this->USER_NICKNAME
                ]);
            }
            else
                return false;
        }
        return true;
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!PasswordHelper::validate($this->USER_PASSWORD_VERIFY, $this->USER_PASSWORD)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }
    
    public static function findIdentity($id) {
        return parent::findIdentity($id);
    }
}
