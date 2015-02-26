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

use Yii;
use yii\base\Model;
use app\models\ActionHistoryExt;
use app\helpers\PasswordHelper;
use app\helpers\SystemHelper;

class SiteForm_Login extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
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
            $user = $this->getUser();

            if (!$user || !PasswordHelper::validate($this->password, $user->USER_PASSWORD)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if(!$this->getUser()->isConfirmed()){
                $this->addError('username', \Yii::t('app/site', 'You need to confirm your email address'));
                return false;
            }
            if ($this->getUser()->isBlocked()) {
                $this->addError('password', \Yii::t('app/site', 'Your account has been blocked'));
                return false;
            }
            ActionHistoryExt::ahUserConnection($this->getUser()->USER_ID, SystemHelper::IDENTITY);
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*7 : 0);
        } else {
            ActionHistoryExt::ahUserTriedConnection($this->getUser()->USER_ID, SystemHelper::IDENTITY);
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByMail($this->username);
        }

        return $this->_user;
    }
}