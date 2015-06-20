<?php

namespace frontend\models;

use yii\log\Logger;

use common\models\User;
use common\models\ActionHistoryExt;
use common\models\Token;
use common\models\TokenExt;

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
            $this->setScenario('user_AsMember_register');
            $this->update();
            $ah = ActionHistoryExt::ahUserMemberRegistration($this->USER_ID);
            $token = Token::createToken($this->USER_ID, TokenExt::TYPE_MEMBER_CONFIRMATION);
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
