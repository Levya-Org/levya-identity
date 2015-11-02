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

namespace common\models;

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;
use yii\helpers\Url;

/**
 * This is the model class for table "TOKEN".
 *
 * @property string $TOKEN_ID
 * @property string $TOKEN_CODE
 * @property string $TOKEN_CREATEDATE
 * @property integer $TOKEN_TYPE
 * @property string $USER_USER_ID
 *
 * @property USER $r_User
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
            ['USER_USER_ID', 'exist', 'targetClass' => 'common\models\USER', 'targetAttribute' => 'USER_ID'],
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
    public function getr_User()
    {
        return $this->hasOne(USER::className(), ['USER_ID' => 'USER_USER_ID']);
    }
    
    
    /**
     * @return string
     */
    public function getUrl()
    {
         switch ($this->TOKEN_TYPE) {
            case TokenExt::TYPE_USER_CONFIRMATION:
            case TokenExt::TYPE_MEMBER_CONFIRMATION:
                $route = 'registration/confirm';
                $params = [
                    'mail' => $this->r_User->USER_MAIL,
                    'token' => $this->TOKEN_CODE,
                ];
                break;
            case TokenExt::TYPE_CONFIRM_NEW_EMAIL:
                break;
            case TokenExt::TYPE_RECOVERY:             
                break;
            case TokenExt::TYPE_CNIL_ACCESS:
                $route = 'profile/view-raw';
                $params = [
                    'token' => $this->TOKEN_CODE,
                ];
                break;
            case TokenExt::TYPE_CNIL_PARTIAL_DELETE:
                $route = 'profile/cnil-pdelete';
                $params = [
                    'token' => $this->TOKEN_CODE,
                ];
                break;
            case TokenExt::TYPE_CNIL_FULL_DELETE:
                $route = 'profile/cnil-fdelete';
                $params = [
                    'token' => $this->TOKEN_CODE,
                ];
                break;
            default:
                Yii::getLogger()->log('Unknow Token type', Logger::LEVEL_WARNING);
        }

        return Url::to(($route+$params), 'https');
    }
    
    /**
     * Is token expired
     * @return bool 
     */
    public function getIsExpired()
    {
        switch ($this->TOKEN_TYPE) {
            case TokenExt::TYPE_USER_CONFIRMATION:
                $expirationTime = Param::getParamValue('token:confirmUserWithin');
                break;
            case TokenExt::TYPE_MEMBER_CONFIRMATION:
                $expirationTime = Param::getParamValue('token:confirmMemberWithin');
                break;
            case TokenExt::TYPE_CONFIRM_NEW_EMAIL:
                $expirationTime = Param::getParamValue('token:confirmEmailWithin');
                break;
            case TokenExt::TYPE_RECOVERY:
                $expirationTime = Param::getParamValue('token:recoverWithin');
                break;
            case TokenExt::TYPE_CNIL_ACCESS:
            case TokenExt::TYPE_CNIL_PARTIAL_DELETE:
            case TokenExt::TYPE_CNIL_FULL_DELETE:
                $expirationTime = Param::getParamValue('token:cnilWithIn');
                break;
            default:
                Yii::getLogger()->log('Unknow Token type', Logger::LEVEL_WARNING);
                break;
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
     * @return \common\models\Token
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
