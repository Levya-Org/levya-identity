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

namespace app\models;

use yii\log\Logger;

use common\models\User;
use common\models\ActionHistoryExt;

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
     * Creates new confirmation token and sends it to the user.
     *
     * @return bool
     */
    public function registerAsMember()
    {
        \Yii::getLogger()->log('RegisterForm_RegisterAsMember::registerAsMember', Logger::LEVEL_TRACE);
        if ($this->validate()) {
            $model->update();
            $ah = ActionHistoryExt::ahUserMemberRegistration($model->USER_ID);
            $token = Token::createToken($model->USER_ID, Token::TYPE_MEMBER_CONFIRMATION);
            //TODO mail
            //TODO donation
            \Yii::$app->session->setFlash('user.confirmation_sent');
            return true;
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
