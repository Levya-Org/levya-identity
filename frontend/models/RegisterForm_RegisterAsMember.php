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

namespace frontend\models;

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;

use common\models\User;
use common\models\Project;
use common\models\ActionHistoryExt;
use common\models\Token;
use common\models\TokenExt;
use common\helpers\MailHelper;

class RegisterForm_RegisterAsMember extends User
{
    public $USER_PASSWORD_VERIFY;
    
    /** @inheritdoc */
    public function rules()
    {
        return array_merge(User::rules(), [
            [['USER_PASSWORD_VERIFY'], 'required'],
            [['USER_PASSWORD_VERIFY'], 'validatePassword'],
        ]);
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'USER_PASSWORD_VERIFY' => \Yii::t('app/user', 'User  Password Verify'),
        ];
    }

    /** @inheritdoc */
    public function formName()
    {
        return 'registrationAsMember-form';
    }   

    /**
     * Register a User as Member 
     * @return bool
     */
    public function registerAsMember()
    {
        \Yii::getLogger()->log('RegisterForm_RegisterAsMember::registerAsMember', Logger::LEVEL_TRACE);
        $transaction = $this->getDb()->beginTransaction();
        if ($this->validate()) {
            try {
                if($this->update() !== false){
                    //Add to Levya Project Member
                    $memberPosition = Project::findOne(['PROJECT_PRIORITY' => 0])->getDefaultPosition(); 
                    $memberPosition->addUser($this->USER_ID);
                    //Add to Levya Member Group
                    $groupPosition = \common\models\Group::findOne(['GROUP_LDAPNAME' => 'member']);
                    $actualBelong = $this->r_Belong;
                    $actualBelong->endBelongToNewGroup($groupPosition->GROUP_ID);
                    //AH
                    ActionHistoryExt::ahUserMemberRegistration($this->USER_ID);
                    //Token
                    $token = Token::createToken($this->USER_ID, TokenExt::TYPE_MEMBER_CONFIRMATION);
                    //Mail
                    MailHelper::registrationMemberMail($this, $token);
                    MailHelper::statuteMail($this, Yii::getAlias('@common/mail/FILES/EN_en-Statutes.pdf'));
                    MailHelper::internalRuleMail($this, Yii::getAlias('@common/mail/FILES/En_en-IntenRules.pdf'));
                    //Flash
                    Yii::$app->session->setFlash('user.confirmation_sent');
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                Yii::getLogger()->log('An error occurred while upgrading your user account'.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            }
        }
        return false;
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
