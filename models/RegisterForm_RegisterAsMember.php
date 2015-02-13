<?php

namespace app\models;

use yii\base\Model;
use yii\log\Logger;

use kartik\password\StrengthValidator;

use app\models\User;
use app\models\ActionHistory;

class RegisterForm_RegisterAsMember extends Model
{
    /** @var string */
    public $USER_NICKNAME;

    /** @var string */
    public $USER_MAIL;

    /** @var string */
    public $USER_PASSWORD;
    
    public $USER_LASTNAME;
    public $USER_FORNAME;
    public $USER_ADDRESS;
    public $USER_COUNTRYID;
    public $USER_REGIONID;
    public $USER_CITYID;
    public $USER_PHONE;

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
            [['USER_PASSWORD'], StrengthValidator::className(), 'preset'=>'fair', 'userAttribute'=>'USER_NICKNAME'],
            
            [['USER_LASTNAME', 'USER_FORNAME', 'USER_NICKNAME', 'USER_SECRETKEY'], 'string', 'max' => 80],
            [['USERSTATE_USERSTATE_ID', 'COUNTRIE_CountryId'], 'integer'],
            [['USER_ADDRESS'], 'string'],
            [['USER_PHONE'], 'string', 'max' => 20],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'USER_LASTNAME' => \Yii::t('app/user', 'User  Lastname'),
            'USER_FORNAME' => \Yii::t('app/user', 'User  Forname'),
            'USER_ADDRESS' => \Yii::t('app/user', 'User  Address'),
            'USER_PHONE' => \Yii::t('app/user', 'User  Phone'),
            'USER_MAIL' => \Yii::t('app/user', 'User  Mail'),
            'USER_NICKNAME' => \Yii::t('app/user', 'User  Nickname'),
            'USER_PASSWORD' => \Yii::t('app/user', 'User  Password'),
            'REGION_RegionID' => \Yii::t('app/user', 'Region  Region ID'),
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
        \Yii::getLogger()->log('User Resend Confirmation', Logger::LEVEL_TRACE);
        if ($this->validate()) {
            $model = new User([
                'scenario' => 'user_register',
                'USER_LASTNAME' => $this->USER_LASTNAME,
                'USER_FORNAME' => $this->USER_FORNAME,
                'USER_ADDRESS' => $this->USER_ADDRESS,
                'COUNTRIE_CountryId' => $this->USER_COUNTRYID,
                'USER_PHONE' => $this->USER_PHONE,
                'USER_MAIL' => $this->USER_MAIL,
                'USER_NICKNAME' => $this->USER_NICKNAME,
                'TMP_PASSWORD' => $this->USER_PASSWORD
            ]);
            $model->create();
            $ah = ActionHistory::ahUserCreation($model->USER_ID);
            $token = Token::createToken($model->USER_ID, Token::TYPE_CONFIRMATION);
            //TODO gestion erreur 
            //TODO mail
            
            \Yii::$app->session->setFlash('user.confirmation_sent');
            return true;
        }

        return false;
    }
}
