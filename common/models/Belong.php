<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\log\Logger;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "BELONG".
 *
 * @property string $BELONG_ID
 * @property string $BELONG_FROM
 * @property string $BELONG_TO
 * @property string $USER_USER_ID
 * @property integer $GROUP_GROUP_ID
 *
 * @property GROUP $gROUPGROUP
 * @property USER $uSERUSER
 */
class Belong extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BELONG';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USER_USER_ID', 'GROUP_GROUP_ID'], 'required'],
            [['BELONG_FROM', 'BELONG_TO'], 'safe'],
            [['USER_USER_ID', 'GROUP_GROUP_ID'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BELONG_ID' => Yii::t('app/user', 'Belong  ID'),
            'BELONG_FROM' => Yii::t('app/user', 'Belong  From'),
            'BELONG_TO' => Yii::t('app/user', 'Belong  To'),
            'USER_USER_ID' => Yii::t('app/user', 'User  User  ID'),
            'GROUP_GROUP_ID' => Yii::t('app/user', 'Group  Group  ID'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'BELONG_FROM',
                'updatedAtAttribute' => false,
                'value' =>  new Expression('NOW()')
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGROUPGROUP()
    {
        return $this->hasOne(GROUP::className(), ['GROUP_ID' => 'GROUP_GROUP_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUSERUSER()
    {
        return $this->hasOne(USER::className(), ['USER_ID' => 'USER_USER_ID']);
    }
    
    /**
     * Link User to a default Group
     * @param type $userId
     * @return boolean
     * @throws \ErrorException
     */
    public function create($userId)
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing belong');
        }
        try {
            
            if(!isset($userId)){
                \Yii::getLogger()->log('Belong without User ID', Logger::LEVEL_ERROR);
                throw  new \ErrorException('Belong without User ID');
            }
            
            $this->USER_USER_ID = $userId;
            $this->GROUP_GROUP_ID = Group::findOne(['GROUP_ISDEFAULT'=>1])->GROUP_ID;
                    
            if ($this->save()) {
                \Yii::getLogger()->log('Belong has been created', Logger::LEVEL_INFO);
                return true;
            }
            else {
                \Yii::getLogger()->log('Belong hasn\'t been created'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Belong error at creation, see Model error.');
            }
        } catch (Exception $ex) {
            \Yii::getLogger()->log('An error occurred while creating belong inter-table'.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw  $ex;
        }
        return false;
    }
}
