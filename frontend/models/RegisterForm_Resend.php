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

use yii\base\Model;
use yii\log\Logger;
use common\models\User;
use common\models\Token;
use common\models\TokenExt;
use common\models\ActionHistoryExt;
use common\helpers\MailHelper;

/**
 * ResendForm gets user USER_MAIL address and validates if user has already confirmed his account. If so, it shows error
 * message, otherwise it generates and sends new confirmation token to user.
 *
 * @property User $user
 */
class RegisterForm_Resend extends Model
{
    /**
     * @var string
     */
    public $USER_MAIL;

    /**
     * @var User
     */
    private $_user;

    /**
     * @return User
     */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = User::findByMail($this->USER_MAIL);
        }

        return $this->_user;
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            ['USER_MAIL', 'required'],
            ['USER_MAIL', 'email'],
            ['USER_MAIL', 'exist', 'targetClass' => 'common\models\User'],
            ['USER_MAIL', function () {
                if ($this->user != null && $this->user->isConfirmed()) {
                    $this->addError('USER_MAIL', \Yii::t('app/user', 'This account has already been confirmed'));
                }
            }],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'USER_MAIL' => \Yii::t('app/user', 'Email'),
        ];
    }

    /** @inheritdoc */
    public function formName()
    {
        return 'resend-form';
    }

    /**
     * Creates new confirmation token and sends it to the user.
     *
     * @return bool
     */
    public function resend()
    {
        \Yii::getLogger()->log('User Resend Confirmation', Logger::LEVEL_TRACE);
        if ($this->validate()) {
            ActionHistoryExt::ahUserResend($this->user->USER_ID);
            $token = Token::createToken($this->user->USER_ID, TokenExt::TYPE_USER_CONFIRMATION);
            MailHelper::registrationResendMail($this->getUser(), $token);           
            \Yii::$app->session->setFlash('user.confirmation_sent');
            return true;
        }
        return false;
    }
}
