<?php

namespace app\models;

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "TOKEN".
 *
 * @property string $TOKEN_ID
 * @property string $TOKEN_CODE
 * @property string $TOKEN_CREATEDATE
 * @property integer $TOKEN_TYPE
 * @property string $USER_USER_ID
 *
 * @property USER $user
 */
class Token extends \yii\db\ActiveRecord
{    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TOKEN';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TOKEN_TYPE', 'USER_USER_ID'], 'required'],
            [['TOKEN_CREATEDATE'], 'safe'],
            [['TOKEN_TYPE', 'USER_USER_ID'], 'integer'],
            [['TOKEN_CODE'], 'string', 'max' => 45],
            [['TOKEN_CODE'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TOKEN_ID' => Yii::t('app/user', 'Token  ID'),
            'TOKEN_CODE' => Yii::t('app/user', 'Token  Code'),
            'TOKEN_CREATEDATE' => Yii::t('app/user', 'Token  Createdate'),
            'TOKEN_TYPE' => Yii::t('app/user', 'Token  Type'),
            'USER_USER_ID' => Yii::t('app/user', 'User  User  ID'),
        ];
    }
    
    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setAttribute('TOKEN_CODE', \Yii::$app->security->generateRandomString());
                $this->TOKEN_CREATEDATE = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getuser()
    {
        return $this->hasOne(USER::className(), ['USER_ID' => 'USER_USER_ID']);
    }
    
    
    /**
     * @return string
     */
    public function getUrl()
    {
        switch ($this->TOKEN_TYPE) {
            case self::TYPE_CONFIRMATION:
                $route = '/registration/confirm';
                break;
            case self::TYPE_RECOVERY:
                $route = '/registration/reset';
                break;
            case self::TYPE_CONFIRM_NEW_EMAIL:
                $route = '/user/settings/confirm';
                break;
            default:
                throw new \RuntimeException;
        }

        return Url::to([$route, 'id' => $this->USER_USER_ID, 'code' => $this->TOKEN_CODE], true);
    }
    
    /**
     * @return bool Whether token has expired.
     */
    public function getIsExpired()
    {
        switch ($this->TOKEN_TYPE) {
            case TokenExt::TYPE_CONFIRMATION:
            case TokenExt::TYPE_CONFIRM_NEW_EMAIL:
                $expirationTime = \Yii::$app->params['token:confirmWithin'];
                break;
            case TokenExt::TYPE_RECOVERY:
                $expirationTime = \Yii::$app->params['token:recoverWithin'];
                break;
            default:
                throw new \RuntimeException;
        }
        
        $date = null;
        $timestamp = null;
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $timestamp = strtotime($this->TOKEN_CREATEDATE);
        } else {
            $date = strptime($this->TOKEN_CREATEDATE, '%Y-%m-%d %T');
            $timestamp = mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'],
                $date['tm_mon'], $date['tm_mday'], $date['tm_year']+1900);
        }

        return ($timestamp + $expirationTime) < time();
    }
    
    /**
     * Create a Token for a User
     * @param type $userId
     * @param type $tokenType
     * @return \app\models\Token
     */
    public static function createToken($userId, $tokenType){
        
        try{
            if(!isset($userId)){
                Yii::getLogger()->log('Token without User ID', Logger::LEVEL_ERROR);
                throw  new \ErrorException('Token without User ID');
            }
            if(!isset($tokenType)){
                Yii::getLogger()->log('Token without Token Type', Logger::LEVEL_ERROR);
                throw  new \ErrorException('Token without Token Type');
            }
            
            $token = new Token([
                'USER_USER_ID' => $userId,
                'TOKEN_TYPE' => $tokenType
            ]);
            
            if($token->save()){
                \Yii::getLogger()->log('Token created', Logger::LEVEL_TRACE);
                return $token;
            }
            else {
                \Yii::getLogger()->log('Token error at creation, reason : '.VarDumper::dumpAsString($token->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Token error at creation, see Model error.');
            }
            
        } catch (Exception $ex) {
            Yii::getLogger()->log('An error occurred while creating Token '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw  $ex;
        }
    }
}
