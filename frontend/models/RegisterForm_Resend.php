<?php

namespace frontend\models;

use yii\base\Model;
use yii\log\Logger;
use common\models\User;
use common\models\Token;
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
            $token = Token::createToken($this->user->USER_ID, TokenExt::TYPE_CONFIRMATION);
            MailHelper::registrationResendMail($this->getUser(), $token);           
            \Yii::$app->session->setFlash('user.confirmation_sent');
            return true;
        }
        return false;
    }
}
