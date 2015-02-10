<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\log\Logger;
use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;

use app\helpers\IPHelper;

/**
 * This is the model class for table "ACTION_HISTORY".
 *
 * @property string $ACTION_HISTORY_ID
 * @property string $ACTION_HISTORY_DATE
 * @property integer $ACTION_HISTORY_ACTION
 * @property string $ACTION_HISTORY_IP
 * @property string $USER_USER_ID
 *
 * @property USER $user
 */
class ActionHistory extends \yii\db\ActiveRecord
{    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ACTION_HISTORY';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ACTION_HISTORY_IP', 'USER_USER_ID'], 'required'],
            [['ACTION_HISTORY_ACTION', 'USER_USER_ID'], 'integer'],
            [['ACTION_HISTORY_IP'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ACTION_HISTORY_ID' => Yii::t('app/user', 'Action  History  ID'),
            'ACTION_HISTORY_DATE' => Yii::t('app/user', 'Action  History  Date'),
            'ACTION_HISTORY_ACTION' => Yii::t('app/user', 'Action  History  Action'),
            'ACTION_HISTORY_IP' => Yii::t('app/user', 'Action  History  Ip'),
            'USER_USER_ID' => Yii::t('app/user', 'User  User  ID'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'ACTION_HISTORY_DATE',
                'updatedAtAttribute' => 'ACTION_HISTORY_DATE',
                'value' =>  new Expression('NOW()')
            ],
        ];
    }
    
    public function beforeValidate() {
        if(parent::beforeValidate()){
            if ($this->isNewRecord) {
                $this->ACTION_HISTORY_IP = IPHelper::IPtoBin(Yii::$app->request->userIP);
                return true;
            }
        }
        return false;
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getuser()
    {
        return $this->hasOne(USER::className(), ['USER_ID' => 'USER_USER_ID']);
    }
    
    /**
     * Create an ActionHistory.
     * @param type $ahId ActionHistoryExt Code
     * @param type $userId UserID
     * @throws \RuntimeException
     * @throws \ErrorException
     */
    public function create($ahId, $userId){
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing ActionHistory');
        }
        
        try {
            
            if(!isset($ahId)){
                Yii::getLogger()->log('ActionHistory without AH_* ID', Logger::LEVEL_ERROR);
                throw  new \ErrorException('ActionHistory without AH_* ID');
            }
            if(!isset($userId)){
                Yii::getLogger()->log('ActionHistory without User ID', Logger::LEVEL_ERROR);
                throw  new \ErrorException('ActionHistory without User ID');
            }
            $this->ACTION_HISTORY_ID = $ahId;
            $this->USER_USER_ID = $userId;

            if ($this->save()) {
                Yii::getLogger()->log('ActionHistory has been created', Logger::LEVEL_TRACE);
            }
            else {
                Yii::getLogger()->log('ActionHistory hasn\'t been created : '.VarDumper::dumpAsString($this->getErrors()), Logger::LEVEL_WARNING);
            }
        } catch (Exception $ex) {
            Yii::getLogger()->log('An error occurred while creating action history '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
        }
    }
}
