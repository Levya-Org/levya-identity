<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\log\Logger;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "WORK".
 *
 * @property string $WORK_ID
 * @property string $WORK_FROM
 * @property string $WORK_TO
 * @property integer $WORK_ISACCEPTED
 * @property integer $WORK_ISLOCKED
 * @property string $USER_USER_ID
 * @property integer $PROJECT_PROJECT_ID
 * @property integer $POSITION_POSITION_ID
 *
 * @property USER $r_User
 * @property POSITION $r_Position
 * @property PROJECT $r_Project
 */
class Work extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'WORK';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WORK_FROM', 'WORK_TO'], 'safe'],
            [['USER_USER_ID', 'PROJECT_PROJECT_ID', 'POSITION_POSITION_ID'], 'integer'],
            [['WORK_ISACCEPTED', 'WORK_ISLOCKED'], 'boolean'],
            [['USER_USER_ID', 'PROJECT_PROJECT_ID', 'POSITION_POSITION_ID'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'WORK_ID' => Yii::t('app/project', 'Work  ID'),
            'WORK_FROM' => Yii::t('app/project', 'Work  From'),
            'WORK_TO' => Yii::t('app/project', 'Work  To'),
            'WORK_ISACCEPTED' => Yii::t('app/project', 'Work  Isaccepted'),
            'WORK_ISLOCKED' => Yii::t('app/project', 'Work  Islocked'),
            'USER_USER_ID' => Yii::t('app/project', 'User  User  ID'),
            'PROJECT_PROJECT_ID' => Yii::t('app/project', 'Project  Project  ID'),
            'POSITION_POSITION_ID' => Yii::t('app/project', 'Position  Position  ID'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'WORK_FROM',
                'updatedAtAttribute' => false,
                'value' =>  new Expression('NOW()')
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_User()
    {
        return $this->hasOne(USER::className(), ['USER_ID' => 'USER_USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Position()
    {
        return $this->hasOne(POSITION::className(), ['POSITION_ID' => 'POSITION_POSITION_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Project()
    {
        return $this->hasOne(PROJECT::className(), ['PROJECT_ID' => 'PROJECT_PROJECT_ID']);
    }
    
    /**
     * Save a Work
     * @return boolean
     * @throws \RuntimeException
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public function create(){
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing Work');
        }
        
        $transaction = $this->getDb()->beginTransaction();
        
        try {
            if ($this->save()) {
                \Yii::getLogger()->log('Work has been created', Logger::LEVEL_INFO);                
                
                //TODO
                //ActionHistoryExt::ahUserCreation($this->primaryKey);
                
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('Work hasn\'t been created'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Work error at creation, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while creating Work row '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false;
    }
    
    /**
     * End a work
     * @return boolean
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public function endWork(){
        \Yii::getLogger()->log('work::endWork', Logger::LEVEL_TRACE); 
        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->WORK_TO = new Expression('NOW()');
            if ($this->save()) {                              
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('Work hasn\'t been ended'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Work error at ending, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while ending Work row '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false;
    }
    
    /**
     * Validate a work (make it as accepted)
     * @return boolean
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public function validateWork(){
        \Yii::getLogger()->log('work::validateWork', Logger::LEVEL_TRACE); 
        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->WORK_ISACCEPTED = TRUE;
            if ($this->save()) {                              
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('Work hasn\'t been validated'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Work error at validating, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while validating Work row '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false;
    }
    
    /**
     * End a work and create a new under new position.
     * Directly in accepted state.
     * @param type $userId
     * @param type $projectId
     * @param type $oldPositionId
     * @param type $newPositionId
     * @return boolean
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public static function endWorkToNewPosition($userId, $projectId, $oldPositionId, $newPositionId){
       \Yii::getLogger()->log('work::endWorkToNewPosition', Logger::LEVEL_TRACE); 
        $transaction = Work::getDb()->beginTransaction();
        try {
            $model = Work::findOne([
                'USER_USER_ID' => $userId,
                'PROJECT_PROJECT_ID' => $projectId,
                'POSITION_POSITION_ID' => $oldPositionId,
                'WORK_TO' => null ,
                'WORK_ISACCEPTED' => true,
                ]);                                
            if($model->endWork()){
                $model = new Work([
                    'USER_USER_ID' => $userId,
                    'PROJECT_PROJECT_ID' => $projectId,                                      
                    'POSITION_POSITION_ID' => $newPositionId,
                    'WORK_ISACCEPTED' => true, 
                ]);
                $model->create();
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('Work hasn\'t been ended'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Work error at ending, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while ending Work row '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false; 
    }
}
