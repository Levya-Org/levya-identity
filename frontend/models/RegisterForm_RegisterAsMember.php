<?php

namespace frontend\models;

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;

use common\models\User;
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
    //TODO : RBAC
    public function registerAsMember()
    {
        \Yii::getLogger()->log('RegisterForm_RegisterAsMember::registerAsMember', Logger::LEVEL_TRACE);
        $transaction = $this->getDb()->beginTransaction();
        $this->setScenario('user_AsMember_register');
        if ($this->validate()) {
            try {
                if($this->update() !== false){
                    ActionHistoryExt::ahUserMemberRegistration($this->USER_ID);
                    $token = Token::createToken($this->USER_ID, TokenExt::TYPE_MEMBER_CONFIRMATION);
                    MailHelper::registrationMemberMail($this, $token);
                    MailHelper::statuteMail($this, Yii::getAlias('@common/mail/FILES/EN_en-Statutes.pdf'));
                    MailHelper::internalRuleMail($this, Yii::getAlias('@common/mail/FILES/En_en-IntenRules.pdf'));
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
