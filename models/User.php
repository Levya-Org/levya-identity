<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\log\Logger;
use yii\helpers\VarDumper;

use app\helpers\IPHelper;
use app\helpers\PasswordHelper;


/**
 * This is the model class for table "USER".
 *
 * @property string $USER_ID
 * @property string $USER_LASTNAME
 * @property string $USER_FORNAME
 * @property string $USER_MAIL
 * @property string $USER_NICKNAME
 * @property string $USER_PASSWORD
 * @property string $USER_ADDRESS
 * @property string $USER_PHONE
 * @property string $USER_SECRETKEY
 * @property string $USER_CREATIONDATE
 * @property string $USER_CREATIONIP
 * @property string $USER_REGISTRATIONDATE
 * @property string $USER_REGISTRATIONIP
 * @property string $USER_UPDATEDATE
 * @property string $USER_AUTHKEY
 * @property string $USERSTATE_USERSTATE_ID
 * @property string $USER_LDAPUID
 * @property integer $COUNTRY_CountryId
 * @property double $USER_LONGITUDE
 * @property double $USER_LATITUDE
 *
 * @property ACTIONHISTORY[] $ACTIONHISTORIES
 * @property BELONG[] $BELONGS
 * @property DONATION[] $DONATIONS
 * @property SOCIALACCOUNT[] $SOCIALACCOUNTS
 * @property TOKEN[] $TOKENS
 * @property City $CITIECITY
 * @property Country $COUNTRIECOUNTRY
 * @property REGION $REGIONREGION
 * @property USERSTATE $USERSTATEUSERSTATE
 * @property WORK[] $WORKS
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /** @var string Plain password. Used for model validation. */
    public $TMP_PASSWORD;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'USER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //Required
            [['USER_MAIL', 'USER_NICKNAME', 'USER_PASSWORD', 'USER_SECRETKEY', 'USER_CREATIONDATE', 'USER_REGISTRATIONDATE', 'USER_REGISTRATIONIP', 'USERSTATE_USERSTATE_ID', 'USER_LDAPUID'], 'required', 'on' => 'user_register'],
            [['USER_LASTNAME','USER_FORNAME', 'USER_MAIL', 'USER_NICKNAME', 'USER_PASSWORD', 'USER_ADDRESS', 'USER_PHONE', 'USER_SECRETKEY', 'USER_CREATIONDATE', 'USER_REGISTRATIONDATE', 'USER_REGISTRATIONIP', 'USERSTATE_USERSTATE_ID', 'USER_LDAPUID', 'COUNTRY_CountryId', 'USER_LONGITUDE', 'USER_LATITUDE'], 'required', 'on' => 'user_AsMember_register'],
            
            //USER_NICKNAME
            [['USER_NICKNAME'], 'unique'],
            [['USER_NICKNAME'], 'match', 'pattern' => '/^[\w]{3,15}$/'],
            
            //USER_EMAIL
            [['USER_MAIL'], 'string', 'max' => 254],
            [['USER_MAIL'], 'email'],
            [['USER_MAIL'], 'unique'],
            
            //USER DATE
            [['USER_CREATIONDATE', 'USER_REGISTRATIONDATE', 'USER_UPDATEDATE'], 'date'],
            
            //
            [['USER_LDAPUID'], 'string', 'max' => 100],
            [['USER_LDAPUID'], 'unique'],
            
            //
            [['USER_AUTHKEY'], 'string', 'max' => 32],
            [['USER_AUTHKEY'], 'unique'],
            
            //
            [['USER_SECRETKEY'], 'unique'],
            
            //
            [['USER_LASTNAME', 'USER_FORNAME', 'USER_NICKNAME', 'USER_SECRETKEY'], 'string', 'max' => 80],
            [['USERSTATE_USERSTATE_ID', 'COUNTRY_CountryId'], 'integer'],
            [['USER_ADDRESS'], 'string'],
            [['USER_PASSWORD'], 'string', 'max' => 255],
            [['USER_PHONE'], 'string', 'max' => 20],
            [['USER_REGISTRATIONIP'], 'string', 'max' => 16],
            
            //SAFE
            [['USER_MAIL', 'USER_NICKNAME','USER_LASTNAME','USER_FORNAME','USER_ADDRESS', 'USER_PHONE','COUNTRY_CountryId' ], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['USER_AUTHKEY'], $fields['USER_SECRETKEY'], $fields['USER_PASSWORD']);

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USER_ID' => Yii::t('app/user', 'User  ID'),
            'USER_LASTNAME' => Yii::t('app/user', 'User  Lastname'),
            'USER_FORNAME' => Yii::t('app/user', 'User  Forname'),
            'USER_MAIL' => Yii::t('app/user', 'User  Mail'),
            'USER_NICKNAME' => Yii::t('app/user', 'User  Nickname'),
            'USER_PASSWORD' => Yii::t('app/user', 'User  Password'),
            'USER_ADDRESS' => Yii::t('app/user', 'User  Address'),
            'USER_PHONE' => Yii::t('app/user', 'User  Phone'),
            'USER_SECRETKEY' => Yii::t('app/user', 'User  Secretkey'),
            'USER_CREATIONDATE' => Yii::t('app/user', 'User  Creationdate'),
            'USER_REGISTRATIONDATE' => Yii::t('app/user', 'User  Registrationdate'),
            'USER_REGISTRATIONIP' => Yii::t('app/user', 'User  Registrationip'),
            'USER_UPDATEDATE' => Yii::t('app/user', 'User  Updatedate'),
            'USER_AUTHKEY' => Yii::t('app/user', 'User  Authkey'),
            'USERSTATE_USERSTATE_ID' => Yii::t('app/user', 'Userstate  Userstate  ID'),
            'USER_LDAPUID' => Yii::t('app/user', 'User  Ldapuid'),
            'COUNTRY_CountryId' => Yii::t('app/user', 'Countrie  Country ID'),
            'USER_LONGITUDE' => Yii::t('app/user', 'User Longitude'), 
            'USER_LATITUDE' => Yii::t('app/user', 'User Latitude')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'user_register' => ['USER_MAIL', 'USER_NICKNAME', 'password','!USER_PASSWORD', '!USER_SECRETKEY', '!USERSTATE_USERSTATE_ID', '!USER_LDAPUID'],
            'user_AsMember_register' => ['USER_LASTNAME','USER_FORNAME', 'USER_MAIL', 'USER_NICKNAME', '!USER_PASSWORD', 'USER_ADDRESS', 'USER_PHONE', '!USER_SECRETKEY', '!USERSTATE_USERSTATE_ID', '!USER_LDAPUID', 'COUNTRY_CountryId', 'USER_LONGITUDE', 'USER_LATITUDE'], //NEED BETTER DB data
            'user_update'   => ['USER_NICKNAME', 'USER_MAIL', 'USER_PASSWORD'],
            'user_AsMember_update' => ['USER_NICKNAME', 'USER_MAIL', 'USER_PASSWORD'],
            'user_settings' => ['USER_NICKNAME', 'USER_MAIL', 'USER_PASSWORD'],
            'user_AsMember_settings' => ['USER_NICKNAME', 'USER_MAIL', 'USER_PASSWORD']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'USER_CREATIONDATE',
                'updatedAtAttribute' => 'USER_UPDATEDATE',
                'value' =>  new Expression('NOW()')
            ],
        ];
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->USER_AUTHKEY = Yii::$app->getSecurity()->generateRandomString();
                $this->USER_LASTNAME = strtoupper($this->USER_LASTNAME);
                $this->USER_MAIL = strtolower($this->USER_MAIL);
                $this->USER_CREATIONIP = IPHelper::IPtoBin(Yii::$app->request->userIP);
            }
            else {
                //TODO ActionHistory
                if (isset($this->scenario)) {
                    switch ($this->scenario) {
                        case 'user_register':
                        case 'user_AsMember_register':
                            $this->USER_REGISTRATIONIP = IPHelper::IPtoBin(Yii::$app->request->userIP);
                            $this->USER_REGISTRATIONDATE = new Expression('NOW()');
                            break;
                        default:
                            break;
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function afterFind() {
        if(parent::afterFind()){
            $this->USER_CREATIONIP = IPHelper::BinToStr($this->USER_CREATIONIP);
            $this->USER_REGISTRATIONIP = IPHelper::BinToStr($this->USER_REGISTRATIONIP);
            return true;
        }
    }

    // <editor-fold defaultstate="collapsed" desc="RELATIONS">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getACTIONHISTORIES()
    {
        return $this->hasMany(ActionHistory::className(), ['USER_USER_ID' => 'USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBELONGS()
    {
        return $this->hasMany(Belong::className(), ['USER_USER_ID' => 'USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDONATIONS()
    {
        return $this->hasMany(Donation::className(), ['USER_ID' => 'USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOCIALACCOUNTS()
    {
        return $this->hasMany(SOCIALACCOUNT::className(), ['USER_USER_ID' => 'USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTOKENS()
    {
        return $this->hasMany(Token::className(), ['USER_USER_ID' => 'USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCOUNTRIECountry()
    {
        return $this->hasOne(Country::className(), ['CountryId' => 'COUNTRY_CountryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUSERSTATEUSERSTATE()
    {
        return $this->hasOne(USERSTATE::className(), ['USERSTATE_ID' => 'USERSTATE_USERSTATE_ID']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWORKS() {
        return $this->hasMany(WORK::className(), ['USER_USER_ID' => 'USER_ID']);
    }


    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="AUTH">
    public function getAuthKey() {
        return $this->USER_AUTHKEY;
    }

    public function getId() {
        return $this->USER_ID;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() == $authKey;
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }   
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="GETTER">
    /**
     * Find a User by Email
     * @param type $userMail
     * @return type
     */
    public static function findByMail($userMail){
        \Yii::getLogger()->log('findByMail', Logger::LEVEL_TRACE);
        return User::findOne([
            'USER_MAIL' => strtolower($userMail)
        ]);
    }
    
    public function isConfirmed(){
        \Yii::getLogger()->log('isConfirmed', Logger::LEVEL_TRACE);
        return $this->USER_REGISTRATIONDATE != null;
    }
    
    
    /**
     * Get if User is blocked / banned or not
     * Todo
     * @return boolean
     */
    public function isBlocked(){
        \Yii::getLogger()->log('isBlocked', Logger::LEVEL_TRACE);
        return false;
    }

    // </editor-fold>

    public function create(){
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }
        
        $transaction = $this->getDb()->beginTransaction();
        
        try {
            $this->setAttribute('USER_PASSWORD', PasswordHelper::hash($this->TMP_PASSWORD));
            $this->USER_SECRETKEY = PasswordHelper::generate(80);
            $this->USERSTATE_USERSTATE_ID = UserState::findOne(['USERSTATE_DEFAULT' => 1])->USERSTATE_ID;
//            //TODO 
//            $this->USER_LDAPUID = LDAPHelper::generateUserUID($this);
            $this->USER_LDAPUID = $this->USER_NICKNAME;           
            
            if ($this->save()) {
                \Yii::getLogger()->log('User has been created', Logger::LEVEL_INFO);
                \Yii::$app->session->setFlash('user.confirmation_sent');
                
                //LEVYA SYSTEM
                {
                    $belong = new Belong();
                    if(!$belong->create($this->primaryKey)){
                        throw new Exception;
                    }
                }
                //RBAC
                {
                    $userRole = \Yii::$app->authManager->getRole('user');
                    \Yii::$app->authManager->assign($userRole, $this->primaryKey);
                }
                
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('User hasn\'t been created'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
            }
        } catch (Exception $exc) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while creating user account'.VarDumper::dumpAsString($exc), Logger::LEVEL_ERROR);
        }
        return false;
    }
    
    public function confirm($token){
        $token = Token::findOne(['TOKEN_CODE' => $token]);
            
        if($token != null 
                && !$token->getIsExpired() 
                && $token->USER_USER_ID == $this->USER_ID){
            $this->setScenario('user_register');
            if($this->save()){
                $token->delete();
            }
            return true;
        }
        return false;        
    }

}
