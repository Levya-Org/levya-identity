<?php

namespace app\models;

use yii\base\Model;
use yii\log\Logger;
use app\models\User;
use app\models\ActionHistoryExt;
use app\models\TokenExt;

use common\helpers\LDAPHelper;
use common\helpers\MailHelper;

use kartik\password\StrengthValidator;

class RegisterForm_Register extends Model
{
    /** @var string */
    public $USER_NICKNAME;

    /** @var string */
    public $USER_MAIL;

    /** @var string */
    public $USER_PASSWORD;

    /** @inheritdoc */
    public function rules()
    {
        return [
            //USER_NICKNAME
            [['USER_NICKNAME'], 'required'],
            [['USER_NICKNAME'], 'match', 'pattern' => '/^[\w]{3,15}$/'],
            [['USER_NICKNAME'], 'string', 'min' => 3, 'max' => 20],
            [['USER_NICKNAME'], 'unique', 'targetClass' => 'app\models\User',
                'message' => \Yii::t('app/user', 'This username has already been taken')],
            
            //USER_EMAIL
            [['USER_MAIL'], 'required'],
            [['USER_MAIL'], 'string', 'max' => 254],
            [['USER_MAIL'], 'email'],
            [['USER_MAIL'], 'unique', 'targetClass' => 'app\models\User',
                'message' => \Yii::t('app/user', 'This email address has already been taken')],
            
            [['USER_PASSWORD'], 'required'],
            [['USER_PASSWORD'], StrengthValidator::className(), 'preset'=>'fair', 'userAttribute'=>'USER_NICKNAME']
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'USER_MAIL' => \Yii::t('app/user', 'User  Mail'),
            'USER_NICKNAME' => \Yii::t('app/user', 'User  Nickname'),
            'USER_PASSWORD' => \Yii::t('app/user', 'User  Password'),
        ];
    }

    /** @inheritdoc */
    public function formName()
    {
        return 'registration-form';
    }

    /**
     * Creates new confirmation token and sends it to the user.
     *
     * @return bool
     */
    public function register()
    {
        \Yii::getLogger()->log('User Registration', Logger::LEVEL_TRACE);
        if ($this->validate()) {
            $user = new User([
                'scenario' => 'user_register',
                'USER_MAIL' => $this->USER_MAIL,
                'USER_NICKNAME' => $this->USER_NICKNAME,
                'TMP_PASSWORD' => $this->USER_PASSWORD,
                'USER_PASSWORD' => $this->USER_PASSWORD
            ]);
            
            if($user->create()){
                try {
                    $token = Token::createToken($user->USER_ID, TokenExt::TYPE_CONFIRMATION);
                    MailHelper::registrationMail($user, $token);

                    \Yii::$app->session->setFlash('user.confirmation_sent');
                } catch (Exception $ex) {
                    \Yii::getLogger()->log('An error occurred while creating user account'.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
                }
                return true;
            }
        }
        return false;
    }
}
